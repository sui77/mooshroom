<?php

if (isset($argv[1]) && $argv[1] == 'delete') {
    echo "delete...\n";
    exec('rm -rf /var/lib/mooshroom');
    exec('deluser --remove-home mooshroom');
    exec('rm /etc/apache2/sites-available/mooshroom.conf');

    exec('apt-get purge supervisor');
}

MooshroomInstaller::run();

class MooshroomInstaller {

    private $extensions = array('gd', 'ssh2', 'curl', 'xmlrpc');
    private $packages   = array('supervisor', 'nodejs-legacy', 'npm', 'git', 'tar');
    private $packagesAdminserver = array('redis-server', 'openjdk-8-jre-headless', 'composer');

    private $_installationType = 1;
    private $_linuxUser        = 'mooshroom';
    private $_linuxHomeDir     = '/home/mooshroom';
    private $_cpUser           = 'admin';
    private $_cpPass           = 'password';
    private $_baseUrl          = '';
    private $_supervisorRpc    = array();

    private function __construct() {
        $this->_baseUrl = 'http://' . gethostname() . '/';
    }

    public static function run() {
        $m = new self();


        $m->checkUser();
        $m->echoBanner();
        $m->checkDistro();
        $m->getInstallationType();
        $m->installPhpExtensions();
        $m->installPackages();
        $m->createLinuxUser();
        $m->createDirectories();
        $m->createSshKeys();
        $m->installLatestRelease();
        $m->setupMooshroomConfig();
        $m->setupSupervisorConfig();
        $m->addHostToAdmin();
        $m->initDatabase();
        $m->saveConfig();
    }

    private function echoBanner() {
        echo "\n";
        echo "                           _                               \n";
        echo "                          | |                              \n";
        echo " _ __ ___   ___   ___  ___| |__  _ __ ___   ___  _ __ ___  \n";
        echo "| '_ ` _ \ / _ \ / _ \/ __| '_ \| '__/ _ \ / _ \| '_ ` _ \ \n";
        echo "| | | | | | (_) | (_) \__ \ | | | | | (_) | (_) | | | | | |\n";
        echo "|_| |_| |_|\___/ \___/|___/_| |_|_|  \___/ \___/|_| |_| |_|\n";
        echo "\n";
    }

    private function checkUser() {
        $processUser = posix_getpwuid(posix_geteuid());
        if ($processUser['name'] != 'root') {
            $this->_error("Please run this installer as root.");
        }
    }

    private function checkDistro() {
        if (!preg_match('/ubuntu/i', php_uname())) {
            $this->_warn("Mooshroom was developed and tested on ubuntu. It might not work on " . php_uname('s') . " " .  php_uname('v') . ".");
            if ($this->_confirm('Do you want to continue anyways?', array('y', 'n')) == 'n') {
                $this->_error('Installation aborted.');
            }
        }
    }

    private function getInstallationType() {
        $this->_installationType = $this->_confirm('Do you want to install a adminserver (1) or an additional node (2)', array('1', '2'), $this->_installationType);
    }

    private function installPhpExtensions() {
        if ($this->_installationType == 2) {
            return;
        }
        foreach ($this->extensions as $name) {
            if (!extension_loaded($name)) {
                if ($this->_confirm('php extension "' . $name . '" missing. Do you want install it?', array('y', 'n'), 'y') == 'y') {
                    passthru("apt-get install php-" . $name);
                } else {
                    $this->_error('Installation aborted.');
                }
            }
        }
        passthru("apache2ctl restart");
    }

    private function installPackages() {
        $packages = ($this->_installationType == 1) ? array_merge($this->packages, $this->packagesAdminserver) : $this->packages;
        foreach ($packages as $name) {
            if (!$this->_packageExists($name)) {
                if ($this->_confirm('"' . $name . '" missing. Do you want install it?', array('y', 'n'), 'y') == 'y') {
                    passthru("apt-get install " . ($name));
                } else {
                    $this->_error('Installation aborted.');
                }
            }
        }
    }

    private function createLinuxUser() {
        $username = $this->_confirm('Which linux user to run minecraft servers?', null, $this->_linuxUser);
        $out = array();
        exec('id -u ' . $username, $out, $err);
        if (count($out) == 0) {
            if ($this->_confirm("User doesn't exist. Create?", array('y', 'n'), 'y') == 'y') {
                passthru('adduser --disabled-password -gecos "" ' . $username );
                passthru('addgroup ' . $username . ' www-data');
                $this->_linuxUser = $username;
                $this->_linuxHomeDir = exec('echo ~' . $username);
            } else {
                $this->createLinuxUser();
            }
        }

        if ($this->_linuxUser == 'root') {
            if ($this->_confirm('It is not recommended to run as root. Are you really sure?', array('y', 'n'), 'n') == 'n') {
                $this->createLinuxUser();
            }
        }
    }

    private function createDirectories() {
        $directories = array(
            '/var/lib/mooshroom',
            '/var/lib/mooshroom/sshkeys/',
            '/var/lib/mooshroom/source/',
            '/var/lib/mooshroom/tmp/',
            '/var/lib/mooshroom/files/',
            '/var/lib/mooshroom/files/jar',
            '/var/lib/mooshroom/files/plugins',
            '/var/lib/mooshroom/files/schematics',
            '/var/lib/mooshroom/supervisord.conf/',
        );
        foreach ($directories as $d) {
            if (!file_exists($d)) {
                echo "mkdir " . $d . "\n";
                passthru('mkdir ' . $d . '; chown ' . $this->_linuxUser . ':' . $this->_linuxUser . ' ' . $d );
            }
        }
        passthru('chmod 777 /var/lib/mooshroom/tmp/');

        if (!file_exists($this->_linuxHomeDir . '/.ssh')) {
            passthru('mkdir ' . $this->_linuxHomeDir . '/.ssh');
            passthru('chown ' . $this->_linuxUser . ':' . $this->_linuxUser . ' ' . $this->_linuxHomeDir . '/.ssh');
            passthru('chmod 700 ' . $this->_linuxHomeDir . '/.ssh');
        }
        exit('createsshfolder');
    }

    private function createSshKeys() {
        if ($this->_installationType == 2) {
            return;
        }
        if (!file_exists('/var/lib/mooshroom/sshkeys/id_rsa')) {
            passthru('ssh-keygen -t rsa -b 2048 -C "' . $this->_linuxUser . '@' . gethostname() . '" -f /var/lib/mooshroom/sshkeys/id_rsa -N ""');
            passthru('cp /var/lib/mooshroom/sshkeys/id_rsa /var/lib/mooshroom/sshkeys/id_rsa_www-data');
            passthru('cp /var/lib/mooshroom/sshkeys/id_rsa.pub /var/lib/mooshroom/sshkeys/id_rsa_www-data.pub');
            passthru('chown -R ' . $this->_linuxUser . ':' . $this->_linuxUser . ' /var/lib/mooshroom/sshkeys');
            passthru('chown www-data:www-data /var/lib/mooshroom/sshkeys/id_rsa_www-data');
            passthru('chown www-data:www-data /var/lib/mooshroom/sshkeys/id_rsa_www-data.pub');
        }

        if (!file_exists($this->_linuxHomeDir . '/.ssh/authorized_keys')) {
            passthru('touch ' . $this->_linuxHomeDir . '/.ssh/authorized_keys');
            passthru('chown ' . $this->_linuxUser . ':' . $this->_linuxUser . ' '. $this->_linuxHomeDir . '/.ssh/authorized_keys');
            passthru('chmod 644 '. $this->_linuxHomeDir . '/.ssh/authorized_keys');
        }

        $this->_authorizeKey(file_get_contents('/var/lib/mooshroom/sshkeys/id_rsa.pub'));
    }

    private function _authorizeKey($pubkey) {
        echo "authorize " . $pubkey . "\n=======\n";
        $authorized = file_get_contents($this->_linuxHomeDir . '/.ssh/authorized_keys');
        if (strstr($authorized, $pubkey) === false) {
            passthru('echo "' . $pubkey . '" >> ' . $this->_linuxHomeDir . '/.ssh/authorized_keys');
        }
    }

    private function installLatestRelease() {
        $f = file_get_contents('https://github.com/sui77/mooshroom/releases/latest');
        if (preg_match('/a href="([^"]*?)\.tar.gz"/si', $f, $m)) {
            $tmp = explode('/', $m[1]);
            $version = str_replace('v', '', $tmp[ count($tmp) - 1]);
            if (!file_exists('/var/lib/mooshroom/source/mooshroom-' . $version)) {
                echo "downloading latest release ($version) from github\n";
                copy('https://github.com' . $m[1] . '.tar.gz', '/var/lib/mooshroom/source/' . $version . '.tar.gz');

                passthru('cd /var/lib/mooshroom/source; tar xzvf ' . $version . '.tar.gz' );
                passthru('chown -R ' . $this->_linuxUser . ':' . $this->_linuxUser . ' /var/lib/mooshroom/source/mooshroom-' . $version );
                passthru('runuser -l ' . $this->_linuxUser . ' -c \'cd /var/lib/mooshroom/source/mooshroom-' . $version . '; composer install\'');
                passthru('runuser -l ' . $this->_linuxUser . ' -c \'cd /var/lib/mooshroom/source/mooshroom-' . $version . '/node; npm install\'');

                exec('ln -sfT /var/lib/mooshroom/source/mooshroom-' . (str_replace('v', '', $version)) . ' /var/lib/mooshroom/current');
            }
        }
    }

    private function setupMooshroomConfig() {
        if ($this->_installationType == 2) {
            return;
        }
        $this->_cpUser  = $this->_confirm('Chose your admin username', null, 'admin');
        $this->_cpPass  = $this->_confirm('Chose your admin password', null, 'password');
        $this->_baseUrl = $this->_confirm('Base url?', null, $this->_baseUrl);

        $url = parse_url($this->_baseUrl);

        if (!file_exists('/etc/apache2/sites-available/mooshroom.conf')) {
            if ($this->_confirm('Do you want me to set up apache vhost config?', array('y', 'n'), 'y')) {
                $tmp = file_get_contents('/var/lib/mooshroom/current/config/templates/mooshroom_apache.conf');
                $tmp = str_replace( array('{servername}'), array($url['host']), $tmp);
                echo "=== vhost config: ===\n";
                echo $tmp;
                echo "=====================\n";
                file_put_contents('/etc/apache2/sites-available/mooshroom.conf', $tmp);
                passthru("a2ensite mooshroom");
                passthru("a2enmod rewrite");
                passthru("apache2ctl restart");
            }
        }
    }

    private function addHostToAdmin() {
        if ($this->_installationType == 1) {
            return;
        }

        $repeat = true;
        do {
            $name = $this->_confirm('Unique name for this server');

            $webCp = $this->_confirm('Mooshroom webadmin URL:', null, 'http://mooshroom/');
            $webCp = preg_replace('/\/*$/', '', $webCp);

            if ($info = json_decode(file_get_contents($webCp . '/api/getinfo?name=' . urlencode($name)), 1)) {
                if (isset($info['pubKey']) && preg_match('/^ssh/', $info['pubKey'])) {

                    $this->_authorizeKey($info['pubKey']);
                    $repeat = false;
                } else {
                    $this->_error('Could not retreive public key from ' . $webCp . '/api/getinfo');
                }
            } else {
                $this->_error('Could not connect to ' . $webCp . '/api/getinfo');
            }
        } while ($repeat);
        $ip = $this->_confirm('Public IP from this server:', null, $info['yourIP']);
        $port = $this->_confirm('Ssh port from this server:', null, 22);

        $data = base64_encode( json_encode( array(
            'name' => $name,
            'ip' => $ip,
            'port' => $port,
            'sshUsername' => $this->_linuxUser,
            'home' => $this->_linuxHomeDir
        )));

        echo file_get_contents($webCp . '/api/addhost?data=' . $data);
        echo "\n";
    }

    private function setupSupervisorConfig() {
        $sconfig = $this->_getSupervisorConfig();
        copy( '/etc/supervisor/supervisord.conf', '/etc/supervisor/supervisord.conf.bak_' . date('YmdHis') );
        if (!isset($sconfig['inet_http_server'])) {

            $string = sha1( md5( sha1( time() . rand(0,999999) . serialize($this)) ) );
            $sconfig['inet_http_server']['username'] = substr($string, 0, 6);
            $sconfig['inet_http_server']['password'] = substr($string, 6, 16);
            $sconfig['inet_http_server']['port'] = rand(20000, 30000);
            $fp = fopen('/etc/supervisor/supervisord.conf', 'a');
            fputs($fp, "\n");
            fputs($fp, "[inet_http_server]\n");
            fputs($fp, "username=" . $sconfig['inet_http_server']['username'] . "\n");
            fputs($fp, "password=" . $sconfig['inet_http_server']['password'] . "\n");
            fputs($fp, "port=" . $sconfig['inet_http_server']['port'] . "\n");
            fclose($fp);
        }
        if (!preg_match('/mooshroom/si', $sconfig['include']['files'])) {
            $s = file_get_contents('/etc/supervisor/supervisord.conf');
            $s = preg_replace('/files\s+=[^\n]*/si', 'files = ' . $sconfig['include']['files'] . ' /var/lib/mooshroom/supervisord.conf/*.conf', $s);
            file_put_contents('/etc/supervisor/supervisord.conf', $s);
        }

        if ($this->_installationType == 1) {
            $tmp = file_get_contents('/var/lib/mooshroom/current/config/templates/mooshroom_supervisor.conf');
            $tmp = str_replace(array('{user}', '{name}', '{command}'), array($this->_linuxUser, 'websocket', 'node start.js'), $tmp);
            file_put_contents('/var/lib/mooshroom/supervisord.conf/mooshroom.conf', $tmp);
            exec('supervisorctl update; supervisorctl restart mooshroom_websocket');
        }

        $tmp = file_get_contents('/var/lib/mooshroom/current/config/templates/mooshroom_supervisor.conf');
        $tmp = str_replace(array('{user}', '{name}', '{command}'), array($this->_linuxUser, 'logtail', 'node logObserver.js'), $tmp);
        file_put_contents('/var/lib/mooshroom/supervisord.conf/mooshroom.conf', $tmp);
        exec('supervisorctl update; supervisorctl restart mooshroom_logtail');


        $this->_supervisorRpc = $sconfig['inet_http_server'];
        echo('http://' . $sconfig['inet_http_server']['username'] . ':' . $sconfig['inet_http_server']['password'] . '@mooshroom:' . $sconfig['inet_http_server']['port']) . "\n";
    }

    private function initDatabase() {
        if ($this->_installationType == 2) {
            return;
        }
        $fp = fsockopen('127.0.0.1', 6379);
        fputs($fp, "HSET IDs mcadmin:hosts 1\r\n");
        fputs($fp, "HSET IDs mcadmin:user 1\r\n");
        fputs($fp, "SADD mcadmin:hosts localhost\r\n");
        fputs($fp, "HSET mcadmin:hosts:localhost name localhost\r\n");
        fputs($fp, "HSET mcadmin:hosts:localhost hostname localhost\r\n");
        fputs($fp, "HSET mcadmin:hosts:localhost sshUsername " . $this->_linuxUser . "\r\n");
        fputs($fp, "HSET mcadmin:hosts:localhost home " . $this->_linuxHomeDir. "\r\n");
        fputs($fp, "HSET mcadmin:hosts:localhost id 1\r\n");
        fputs($fp, "HSET mcadmin:hosts:localhost port 22\r\n");
        fputs($fp, "HSET mcadmin:hosts:localhost supervisorapi http://" . $this->_supervisorRpc['username'] . ":" . $this->_supervisorRpc['password'] . "@localhost:" . $this->_supervisorRpc['port'] . "/RPC2\r\n");
        fputs($fp, "SADD mcadmin:user " . $this->_cpUser . "\r\n");
        fputs($fp, "HSET mcadmin:user:" . $this->_cpUser . " id 1\r\n");
        fputs($fp, "HSET mcadmin:user:" . $this->_cpUser . " username " . $this->_cpUser . "\r\n");
        fputs($fp, "HSET mcadmin:user:" . $this->_cpUser . " pass " . $this->_cpPass . "\r\n");
        fputs($fp, "QUIT\r\n");
    }
    private function saveConfig() {
        $fp = fopen('/var/lib/mooshroom/config.json', 'w');
        $config = array(
            'date' => date('Y-m-d H:i:s'),
            'user' => $this->_linuxUser,
            'home' => $this->_linuxHomeDir,
            'supervisor' => $this->_supervisorRpc,
            'url' => $this->_baseUrl,
        );
        fputs($fp, json_encode($config, JSON_PRETTY_PRINT));
        fclose($fp);
    }


    private function _confirm($text, $options = null, $default = null) {
        if (!is_null($default)) {
            //return $default;
        }

        do {
            echo "\033[32m" . $text;

            if (!is_null($options)) {
                echo ' [' . implode("/", $options) . ']';
            }
            if (!is_null($default)) {
                echo ' (default: ' . $default . ')';
            }
            echo ' > ';
            echo "\033[0m";

            $f = fgets(STDIN);

            $f = trim($f);

            if (empty($f) && $default != null) {
                return $default;
            }

            if (is_null($options) || in_array($f, $options)) {
                return $f;
            }


        } while (true);
    }

    private function _packageExists($name) {
        exec('dpkg -l ' . ($name), $out );
        return preg_match('/Version/s', implode('', $out)) && substr($out[count($out)-1], 1, 1) == 'i';
    }

    private function _getSupervisorConfig() {

        if (!file_exists('/etc/supervisor/supervisord.conf')) {
            exit('supervisor config not found');
        }
        $f = file_get_contents('/etc/supervisor/supervisord.conf');
        if (preg_match('/files\s+=\s+(.*)\n/si', $f, $m)) {
            $tmp = explode(' ', $m[1]);
            foreach ($tmp as $dir) {
                $dir = trim($dir);
                $d = opendir( dirname(trim($dir)) );
                while ($file = readdir($d)) {
                    if (preg_match('/.conf$/', $file)) {
                        $f .= "\n" . file_get_contents( dirname($dir) . '/' . $file );
                    }
                }
            }
        }

        $tmp = explode("\n", $f);
        $currentSection = 'none';
        $config = array();
        foreach ($tmp as $line) {
            $tmp2 = explode('=', $line);
            if (preg_match('/^\[(.*?)\]/', $line, $m)) {
                $currentSection = $m[1];
            } else if (count($tmp2) == 2) {
                $config[$currentSection][ trim($tmp2[0]) ] = trim($tmp2[1]);
            }
        }

        return $config;

    }

    private function _error($msg) {
        echo "\033[31m";
        echo $msg;
        echo "\033[0m";
        echo "\n\n";
        exit();
    }

    private function _warn($msg) {
        echo "\033[33;44m";
        echo $msg;
        echo "\033[0m\n";
    }
}
