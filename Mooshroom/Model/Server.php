<?php

namespace Mooshroom\Model;

use Mooshroom\Config;
use Mooshroom\JobQueue;
use Mooshroom\Minecraft\ServerProperties;
use Mooshroom\Ssh;
use Mooshroom\SupervisorRpcClient;
use Predis\Client;

class Server extends KeyValueModelAbstract {

    protected static $_redisKey = 'mcadmin:server';

    private $_gameDirectory = null;
    private $_sshConnection = null;
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
        $this->_gameDirectory = Config::get('gameDir') . '/mc_' . $this->getName();
    }

    private function _sshConnect() {
        if ($this->_sshConnection == null) {
            $host = Hosts::getInstance( $this->get('host') );
            $this->_sshConnection = new Ssh($host->get('hostname'), $host->get('port'), Config::get('sshkey'));
        }
        return $this->_sshConnection;
    }

    private function _scpSend($src, $dst) {
        $this->_sshConnect()->scpSend($src, $dst);
    }

    private function _scpReceive($src, $dst) {
        $this->_sshConnect()->scpReceive($src, $dst);
    }

    private function _ssh($cmd) {
        return $this->_sshConnect()->exec($cmd);
    }

    public function getStatus() {
        if (is_null($this->_status)) {
            try {
                $this->_status = $this->getHost()->getSupervisor()->getProcessInfo('mc_' . $this->getName());
            } catch (\Exception $e) {

            }
        }
        return $this->_status;
    }

    public function isRunning() {
        $s = $this->getStatus();
        return $s['statename'] == 'RUNNING';
    }

    public function getEulaUrl() {
        $eulaTxt = $this->_ssh('cat ' . $this->_gameDirectory . '/eula.txt');
        if (preg_match('/http[a-zA-Z0-9\/\.:_-]*/si', $eulaTxt, $m)) {
            return $m[0];
        }
    }

    public function acceptEula() {
        $this->_ssh('echo "#' . date('r') . '" > ' . $this->_gameDirectory . '/eula.txt');
        $this->_ssh('echo "eula=true" >> ' . $this->_gameDirectory . '/eula.txt');
        $this->set('eula', 'true');
        $this->control('restart');
        //$this->getHost()->getSupervisor()->restartProcess( 'mc_' . $this->getName() );
    }

    public function getPlugins() {
        $dir = opendir( Config::get('files.plugins.localDir'));
        while ($f = readdir($dir)) {
            if (preg_match('/\.jar$/', $f)) {
                $plugins[ $f ] = false;
            }
        }
        $remotePlugins = $this->_sshConnect()->ls( $this->_gameDirectory . '/plugins');
        foreach ($remotePlugins as $name) {
            if (preg_match('/\.jar$/', $name)) {
                $plugins[$name] = true;
            }
        }

        ksort($plugins);
        return $plugins;
    }

    public function getLog() {
        $redis = new Client(Config::get('redis'));
        $log = $redis->lrange('mcadmin:log:' . $this->getName(), 0, 100 );
        return array_reverse($log);
    }

    public function enablePlugin( $name ) {
        $this->_ssh('ln -s /home/minecraft/mcadmin_files/plugins/' . $name . ' ' . $this->_gameDirectory . '/plugins/' . $name);
    }

    public function disablePlugin($name) {
        $this->_ssh('rm ' . $this->_gameDirectory . '/plugins/' . $name);
    }

    public function cmd($cmd) {
        $r = $this->getHost()->getSupervisor()->sendProcessStdin('mc_' . $this->getName(), $cmd . "\r\n");
    }

    public function delete() {
        parent::delete();
        $this->_redis->del(static::$_redisKey . ':log:' . $this->getName() );

        if (preg_match('/^\/home\/minecraft\/mc_/', $this->_gameDirectory)) {
            $this->_ssh('rm -rf ' . $this->_gameDirectory);
        }

        try {
            $supervisor = $this->getHost()->getSupervisor();
            //$supervisor->stopProcess('mc_' . $this->getName());
            try {
                $supervisor->sendProcessStdin('mc_' . $this->getName(), 'stop');
            } catch (\Exception $e) {

            }
            sleep(2);
            $supervisor->removeProcessGroup('mc_' . $this->getName());
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public static function create($name, $data = null) {
        if (! ($s = self::getInstance($name))) {
            $s = parent::create($name, $data);
            $s->createGameDirectory();
            $s->generateSupervisorConfig();

        }
        return $s;
    }

    public function getHost() {
        $h = Hosts::getInstance( $this->get('host') );
        return $h;
    }



    public function control($action) {
        $this->set('restartneeded', 0);

        if ($action == 'stop' || $action == 'restart') {
            //try { $this->getHost()->getSupervisor()->stopProcess('mc_' . $this->getName()); } catch (\Exception $e) { }
            try { $this->getHost()->getSupervisor()->sendProcessStdin('mc_' . $this->getName(), 'stop'); } catch (\Exception $e) { print_r($e); exit(); }

            sleep(2);
        }

        if ($action == 'restart') {
            try { $this->getHost()->getSupervisor()->removeProcessGroup('mc_' . $this->getName()); } catch (\Exception $e) { }
            try { $this->getHost()->getSupervisor()->addProcessGroup('mc_' . $this->getName()); } catch (\Exception $e) { }

        } else if ($action == 'start') {
            try { $this->getHost()->getSupervisor()->startProcess('mc_' . $this->getName()); } catch (\Exception $e) { }
        }
    }

    public function getServerProperties() {
        return new ServerProperties($this->_gameDirectory . '/server.properties', $this->_sshConnect() );
    }

    public function getOps() {
        $wl = $this->_ssh('cat ' . $this->_gameDirectory . '/ops.json');
        return json_decode($wl, 1);

    }

    public function addWhitelist($user) {
        $this->getHost()->getSupervisor()->sendProcessStdin('mc_' . $this->getName(), 'whitelist add ' . $user . "\n");
    }

    public function removeWhitelist($user) {
        $this->getHost()->getSupervisor()->sendProcessStdin('mc_' . $this->getName(),'whitelist remove ' . $user . "\n");
    }

    public function addOp($user, $level) {
        $this->getHost()->getSupervisor()->sendProcessStdin('mc_' . $this->getName(), 'op ' . $user . "\n");
    }

    public function removeOp($user) {
        $this->getHost()->getSupervisor()->sendProcessStdin('mc_' . $this->getName(),'deop ' . $user . "\n");
    }

    public function getWhitelist() {
        $wl = $this->_ssh('cat ' . $this->_gameDirectory . '/whitelist.json');
        return json_decode($wl, 1);
    }

    private function _setJar() {
        $this->_ssh("ln -sf ~/mcadmin_files/binaries/" .  $this->get('jar') . " " . $this->_gameDirectory . "/server.jar");
    }

    public function createGameDirectory() {
        $this->_ssh("mkdir " . $this->_gameDirectory );
        $this->_ssh("mkdir " . $this->_gameDirectory . '/plugins');
        $this->_ssh("mkdir " . $this->_gameDirectory . '/plugins/WorldEdit');
        $this->_ssh("ln -s ~/mcadmin_files/schematics " . $this->_gameDirectory . '/plugins/WorldEdit/schematics');
        $this->_setJar();

        $tmpFile = '/tmp/' .uniqid('server.properties');
        $prop = new ServerProperties($tmpFile);
        $prop->set( array(
            'rcon.port' => $this->get('id') + 40000,
            'query.port' => $this->get('id') + 30000,
            'server-port' => $this->get('id') + 20000,
        ));
        $this->_scpSend($tmpFile, $this->_gameDirectory . '/server.properties');
        unlink($tmpFile);

        $tmpFile = '/tmp/' .uniqid('log4j2');
        $file = file_get_contents( Config::get('baseDir') . '/config/templates/log4j2.xml' );
        $replace = array(
            '{NAME}'    => $this->getName(),
        );
        $file = str_replace( array_keys($replace), array_values($replace), $file);
        $fp = fopen( $tmpFile, 'w');
        fputs($fp, $file);
        fclose($fp);
        $this->_scpSend($tmpFile, $this->_gameDirectory . '/log4j2.xml');
        //unlink($tmpFile);
    }

    public function generateSupervisorConfig($update = false) {

        $file = file_get_contents( Config::get('baseDir') . '/config/templates/supervisor.conf' );
        $replace = array(
            '{JARFILE}' => $this->get('jar'),
            '{MEMORY}'  => $this->get('memory'),
            '{NAME}'    => $this->getName(),
        );
        $file = str_replace( array_keys($replace), array_values($replace), $file);
        $tmpFile = '/tmp/' .uniqid('supervisor.conf');
        $fp = fopen( $tmpFile, 'w' );
        fputs($fp, $file);
        fclose($fp);

        $this->_ssh('rm ' . '/home/minecraft/mcadmin_files/supervisor.conf.d/' . $this->getName() .'.conf');


        $this->_scpSend($tmpFile, '/home/minecraft/mcadmin_files/supervisor.conf.d/' . $this->getName() .'.conf');
        $this->getHost()->getSupervisor()->addProcessGroup('mc_' . $this->getName());


    }


}