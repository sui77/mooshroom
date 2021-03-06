<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Mojang;
use Mooshroom\SpigetAPI;
use Mooshroom\Ssh;

class Api extends ControllerAbstract {

    public function init() {

    }

    public function getinfoAction() {
        header('Content-type: text/json');
        $result = array(
            'yourIP' => $_SERVER['REMOTE_ADDR'],
            'pubKey' => file_get_contents('/var/lib/mooshroom/sshkeys/id_rsa.pub')
        );
        echo json_encode($result);
    }

    public function getinstallerAction() {
        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename="install.php"');
        echo file_get_contents( Config::get('baseDir') . '/docs/install.php');
    }

    public function addhostAction() {
        $data = json_decode( base64_decode( $_GET['data'] ), 1);
        $auth = Config::get('sshkey');
        $auth['username'] = $data['sshUsername'];

        \Mooshroom\Model\Hosts::create($data['name'], array(
            'hostname' => $data['ip'],
            'port' => $data['port'],
            'sshUsername' => $data['sshUsername'],
            'home' => $data['home'],
            //'supervisorapi' => $data['supervisor'],
            'supervisorapiuser' => $data['supervisorapiuser'],
            'supervisorapipass' => $data['supervisorapipass'],
            'supervisorapiport' => $data['supervisorapiport'],
        ));
        print_r($data);
    }

    public function render() {

    }
}