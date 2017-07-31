<?php

namespace Mooshroom\Model;

use Mooshroom\Config;
use Mooshroom\Configfiles;
use Mooshroom\JobQueue;
use Mooshroom\MCServerStatus\Minecraft\Stats;
use Mooshroom\Minecraft\GameRules;
use Mooshroom\Minecraft\ServerProperties;
use Mooshroom\Ssh;
use Mooshroom\SupervisorRpcClient;
use Predis\Client;

class Server extends KeyValueModelAbstract {

    protected static $_redisKey = 'mcadmin:server';

    private $_status = null;

    protected function onChange_memory($value) {
        $this->set('restartneeded', 1);
        $this->generateSupervisorConfig(1);
    }

    protected function onChange_jar($value) {
        $this->set('restartneeded', 1);
        $this->_setJar();
    }

    protected function __construct($_name) {
        parent::__construct($_name);
    }

    public function getGameDirectory() {
        return $this->getHost()->get('home') . '/moo_' . $this->getName();
    }

    public function getStatus($refresh = true) {
        if ($refresh) {
            $status = $this->getHost()->getSupervisor()->getProcessInfo('moo_' . $this->getName(), $refresh);

            if (in_array($status['statename'], array('STOPPED', 'BACKOFF', 'EXITED', 'FATAL'))) {
                $this->set('status', 'STOPPED');
            } else  if (in_array($status['statename'], array('RUNNING')) && $this->get('status') != 'STARTING') {
                    $this->set('status', 'RUNNING');
            }
        }

        return $this->get('status');
    }


    public function isRunning() {
        return $this->getStatus() == 'RUNNING';
    }

    public function getStatusText() {
        return 'blah';
    }

    public function getStats() {


            $socket = @stream_socket_client(sprintf('tcp://%s:%u', $this->getHost()->get('hostname'), $this->getServerProperties()->get('server-port')), $errno, $errstr, 1);

            if (!$socket) {
                return (object) array('is_online' => false) ;
            }

            fwrite($socket, "\xfe\x01");
            $data = fread($socket, 1024);
            fclose($socket);

            $stats = new \stdClass;

            // Is this a disconnect with the ping?
            if ($data == false AND substr($data, 0, 1) != "\xFF") {
                $stats->is_online = false;
                return $stats;
            }

            $data = substr($data, 9);
            $data = mb_convert_encoding($data, 'auto', 'UCS-2');
            $data = explode("\x00", $data);

            $stats->is_online = true;
            list($stats->protocol_version, $stats->game_version, $stats->motd, $stats->online_players, $stats->max_players) = $data;

            return $stats;


    }

    public function getEulaUrl() {
        $eulaTxt = $this->getHost()->ssh('cat ' . $this->getGameDirectory() . '/eula.txt');
        if (preg_match('/http[a-zA-Z0-9\/\.:_-]*/si', $eulaTxt, $m)) {
            return $m[0];
        }
    }

    public function acceptEula() {
        $this->getHost()->ssh('echo "#' . date('r') . '" > ' . $this->getGameDirectory() . '/eula.txt');
        $this->getHost()->ssh('echo "eula=true" >> ' . $this->getGameDirectory() . '/eula.txt');
        $this->set('eula', 'true');
        $this->control('restart');
        //$this->getHost()->getSupervisor()->restartProcess( 'mc_' . $this->getName() );
    }

    public function getPlugins() {
        $plugins = array();
        /*$dir = opendir( Config::get('files.plugins.localDir'));
        while ($f = readdir($dir)) {
            if (preg_match('/\.jar$/', $f)) {
                $plugins[ $f ] = false;
            }
        }*/
        $remotePlugins = $this->getHost()->ls( $this->getGameDirectory() . '/plugins');
        foreach ($remotePlugins as $name) {
            if (preg_match('/\.jar$/', $name)) {
                $plugins[$name] = true;
            }
        }

        ksort($plugins);
        return $plugins;
    }

    public function getConfigfiles() {
        return new Configfiles($this->getHost(), $this->getGameDirectory() );
    }

    public function getLog() {
        $redis = new Client(Config::get('redis'));
        $log = $redis->lrange('mcadmin:log:' . $this->getName(), 0, 100 );
        return array_reverse($log);
    }

    public function enablePlugin( $name ) {
        $this->getHost()->ssh('ln -s /home/minecraft/mcadmin_files/plugins/' . $name . ' ' . $this->getGameDirectory() . '/plugins/' . $name);
    }

    public function disablePlugin($name) {
        $this->getHost()->ssh('rm ' . $this->getGameDirectory() . '/plugins/' . $name);
    }

    public function cmd($cmd) {
        $r = $this->getHost()->getSupervisor()->sendProcessStdin('moo_' . $this->getName(), $cmd . "\r\n");
    }

    public function delete() {
        parent::delete();
        $this->_redis->del(static::$_redisKey . ':log:' . $this->getName() );
        $this->getHost()->ssh('rm -rf ' . $this->getGameDirectory());

        try {
            $supervisor = $this->getHost()->getSupervisor();
            //$supervisor->stopProcess('mc_' . $this->getName());
            try {
                $supervisor->sendProcessStdin('moo_' . $this->getName(), 'stop');
            } catch (\Exception $e) {

            }
            sleep(2);
            $supervisor->removeProcessGroup('moo_' . $this->getName());
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }


    /**
     * @return Hosts
     */
    public function getHost() {
        $h = Hosts::getInstance( $this->get('host') );
        return $h;
    }



    public function control($action) {
        $this->set('restartneeded', 0);

        if ($action == 'stop' || $action == 'restart') {
            echo "stop\n";
            $this->set('status', 'STOPPING');
            try { $this->getHost()->getSupervisor()->sendProcessStdin('moo_' . $this->getName(), 'stop'); } catch (\Exception $e) { print_r($e); exit(); }
            for ($i=0; $i<10; $i++) {
                echo time() . " " . $i . "\n";
                $s = $this->getStatus(1);
                echo $s;
                if ($s == 'STOPPED') {
                    break;
                }
                sleep(1);
            }
        }

        if ($action == 'restart') {
            echo "restart\n";
            $this->set('status', 'STARTING');

            try { echo $this->getHost()->getSupervisor()->removeProcessGroup('moo_' . $this->getName()); } catch (\Exception $e) { print_r($e); }
            try { echo $this->getHost()->getSupervisor()->addProcessGroup('moo_' . $this->getName()); } catch (\Exception $e) { print_r($e);  }
            echo "restart end\n";

        } else if ($action == 'start' || $action == 'restart') {
            echo "start\n";

            $this->set('status', 'STARTING');
            try { $this->getHost()->getSupervisor()->startProcess('moo_' . $this->getName()); } catch (\Exception $e) { }
        }
    }

    public function getServerProperties() {
        return new ServerProperties($this->getGameDirectory() . '/server.properties', $this->getHost()->sshConnect() );
    }

    public function getGamerules() {
        if (true || $this->get('gamerules') < time() + 60*60) {
            $xG = new GameRules();
            foreach ($xG->getData() as $k => $v) {
                $this->getHost()->getSupervisor()->sendProcessStdin('moo_' . $this->getName(), 'gamerule ' . $k);
            }
            $this->set('gamerules', time());
            $this->reload();
        }

        foreach ($this->_data as $k => $v) {
            if (preg_match('/^gamerule:(.*)$/', $k, $m)) {
                $gamerule[$m[1]] = $v;
            }
        }
        return new GameRules( $gamerule );
    }

    public function getOps() {
        $wl = $this->getHost()->ssh('cat ' . $this->getGameDirectory() . '/ops.json');
        return json_decode($wl, 1);

    }

    public function addWhitelist($user) {
        $this->getHost()->getSupervisor()->sendProcessStdin('moo_' . $this->getName(), 'whitelist add ' . $user . "\n");
    }

    public function removeWhitelist($user) {
        $this->getHost()->getSupervisor()->sendProcessStdin('moo_' . $this->getName(),'whitelist remove ' . $user . "\n");
    }

    public function addOp($user, $level) {
        $this->getHost()->getSupervisor()->sendProcessStdin('moo_' . $this->getName(), 'op ' . $user . "\n");
    }

    public function removeOp($user) {
        $this->getHost()->getSupervisor()->sendProcessStdin('moo_' . $this->getName(),'deop ' . $user . "\n");
    }

    public function getWhitelist() {
        $wl = $this->getHost()->ssh('cat ' . $this->getGameDirectory() . '/whitelist.json');
        return json_decode($wl, 1);
    }

    private function _setJar() {
        $this->getHost()->ssh("ln -sf " . Config::get('files.binaries.localDir') . '/' .  $this->get('jar') . ' ' . $this->getGameDirectory() . "/server.jar");
    }

    public static function create($name, $data = null) {
        if (! ($s = self::getInstance($name))) {
            $s = parent::create($name, $data);
            $s->createGameDirectory();
            $s->generateSupervisorConfig();
        }
        return $s;
    }

    public function createGameDirectory() {
        $host = $this->getHost();
        $host->ssh("mkdir " . $this->getGameDirectory() );
        $host->ssh("mkdir " . $this->getGameDirectory() . '/plugins');
        $host->ssh("mkdir " . $this->getGameDirectory() . '/plugins/WorldEdit');
        $host->ssh("ln -s ~/mcadmin_files/schematics " . $this->getGameDirectory() . '/plugins/WorldEdit/schematics');
        $this->_setJar();

        $tmpFile = Config::get('tmpDir') . '/' .uniqid('server.properties');

        $prop = new ServerProperties($tmpFile);
        $prop->set( array(
            'rcon.port' => $this->get('id') + 40000,
            'query.port' => $this->get('id') + 30000,
            'server-port' => $this->get('id') + 20000,
        ));
        echo $tmpFile;
        echo $this->getGameDirectory() . '/server.properties';
        echo $host->scpSend($tmpFile, $this->getGameDirectory() . '/server.properties');
        unlink($tmpFile);

    }

    public function generateSupervisorConfig($update = false) {
        $file = file_get_contents( Config::get('baseDir') . '/config/templates/supervisor.conf' );
        $replace = array(
            '{JARFILE}' => $this->get('jar'),
            '{MEMORY}'  => $this->get('memory'),
            '{GAMEDIR}' => $this->getGameDirectory(),
            '{USER}'    => $this->getHost()->get('sshUsername'),
            '{NAME}'    => 'moo_' . $this->getName(),
        );
        $file = str_replace( array_keys($replace), array_values($replace), $file);
        $tmpFile = Config::get('tmpDir') . '/' .uniqid('supervisor.conf');
        $fp = fopen( $tmpFile, 'w' );
        fputs($fp, $file);
        fclose($fp);
        $this->getHost()->ssh('rm ' . '/var/lib/mooshroom/supervisord.conf/' . $this->getName() .'.conf');
        $this->getHost()->scpSend($tmpFile, '/var/lib/mooshroom/supervisord.conf/' . $this->getName() .'.conf');
        $this->getHost()->getSupervisor()->addProcessGroup('moo_' . $this->getName());
    }


}