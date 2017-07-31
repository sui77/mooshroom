<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Mojang;
use Mooshroom\SpigetAPI;
use Mooshroom\Ssh;

class Ajax extends ControllerAbstract {

    public function init() {
        parent::init();
        $this->assign('errormsg', $this->getParam('errormsg'));
    }

    public function scmdAction() {
        $server = \Mooshroom\Model\Server::getInstance( $_POST['server'] );
        $server->getHost()->getSupervisor()->sendProcessStdin( 'moo_' . $_POST['server'], $_POST['cmd'] );
        echo 'ok';
        exit();
    }

    public function pluginsearchAction() {
        $r = json_decode(SpigetAPI::searchResource($_POST['q'], 'name', 10, 1, '', 'name,icon,testedVersions,tag'), 1);

        /*foreach ($r as &$item) {
            $item['versions'] = json_decode(SpigetAPI::getResourceVersions($item['id']));
        }*/
        header('Content-type: text/json');
        echo json_encode($r);
        exit();
    }

    public function cmdAction() {
        $server = \Mooshroom\Model\Server::getInstance($_POST['server']);
        $server->cmd($_POST['cmd']);
        exit();
    }


    public function uploadAction() {


        if (file_exists($_FILES['files']['tmp_name'][0])) {
            $ssh = \Mooshroom\Model\Hosts::getInstance('localhost')->scpSend( $_FILES['files']['tmp_name'][0], Config::get('files.' . $this->getParam('type') . '.localDir') . '/' . $_FILES['files']['name'][0]);
            echo json_encode(
              array( $_FILES['files']['name'][0] )
            );
        }
        exit();
    }
}