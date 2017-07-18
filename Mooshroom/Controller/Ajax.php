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

    public function pluginsearchAction() {
        $r = SpigetAPI::searchResource($_POST['q'], 'name', 10, 1, '', 'name,icon,testedVersions,tag');
        header('Content-type: text/json');
        echo $r;
        exit();
    }

    public function cmdAction() {
        $server = \Mooshroom\Model\Server::getInstance($_POST['server']);
        $server->cmd($_POST['cmd']);
        exit();
    }


    public function uploadAction() {
        if (file_exists($_FILES['files']['tmp_name'][0])) {
            move_uploaded_file( $_FILES['files']['tmp_name'][0], BASE_PATH . '/config/plugins/' . $_FILES['files']['name'][0] );
            echo json_encode(
              array( $_FILES['files']['name'][0] )
            );
        }
        exit();
    }
}