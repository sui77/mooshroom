<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Controller\ControllerAbstract;
use Mooshroom\Model\Hosts as HostModel;
use Mooshroom\Ssh;

class Hosts extends ControllerAbstract {

    public function indexAction() {

    }

    public function addAction() {
        header('Content-type: text/json');
        ini_set('display_errors', 0);
        $this->_checkSsh();
        $host = $_POST['hostname'];
        $port = 22;
        $tmp = explode(':', $host);
        if (count($tmp) == 2) {
            $host = $tmp[0];
            $port = $tmp[1];
        }

        HostModel::create($_POST['name'], array(
            'hostname' => $host,
            'port' => $port,
            'supervisorapi' => $_POST['supervisorapi']
        ));

        echo json_encode(
            array(
                'ok' => 'true',
            )
        );
        exit();
    }

    private function _checkSsh() {
        $host = $_POST['hostname'];
        $port = 22;
        $tmp = explode(':', $host);
        if (count($tmp) == 2) {
            $host = $tmp[0];
            $port = $tmp[1];
        }
        $ssh = new Ssh($host, $port, Config::get('sshkey'));
        if ($ssh->getLastError() != '') {
            echo json_encode(
                array(
                    'error' => $ssh->getLastError(),
                )
            );
            exit();
        }

        if ($hostModel = HostModel::getInstance($_POST['name'])) {
            echo json_encode(
                array(
                    'error' => 'A host with this name already exists.',
                )
            );
            exit();
        }

        if ($ssh->exec('php -r "echo \'ok\';"') != 'ok') {
            echo json_encode(
                array(
                    'error' => 'php is not installed at ' . $host,
                )
            );
            exit();
        }
        return $ssh;
    }
}