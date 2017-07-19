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


    public function addhostAction() {
        $data = json_decode( base64_decode( $_GET['data'] ), 1);
        $auth = Config::get('sshkey');
        $auth['username'] = $data['username'];

        $ssh = new Ssh($data['ip'], $data['port'], $auth);
        $config = json_decode( $ssh->exec('cat /var/lib/mooshroom/config.json'), 1);
        \Mooshroom\Model\Hosts::create($data['name'], array(
            'hostname' => $data['ip'],
            'port' => $data['port'],
            'sshUsername' => $data['username'],
            'home' => $data['home'],
            'supervisorapi' => 'http://' . $config['supervisor']['username'] . ':' . $config['supervisor']['password'] . '@' . $data['ip'] . ':' . $config['supervisor']['port'] . '/RPC2'
        ));
        print_r($data);
    }

    public function render() {

    }
}