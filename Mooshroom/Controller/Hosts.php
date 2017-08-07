<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Controller\ControllerAbstract;
use Mooshroom\Model\Hosts as HostModel;
use Mooshroom\Ssh;

class Hosts extends ControllerAbstract {

    public function init() {
        parent::init();
        $this->_setActiveNav('hosts');
    }

    public function indexAction() {
        $this->title = 'Hosts';
    }

    public function detailAction() {
        $this->title = 'Hosts';


        $this->host = \Mooshroom\Model\Hosts::getInstance($this->getParam('hostname'));
        $this->formdata = $this->host->get();

        if (isset($_POST['name'])) {
            $fields = array(
                    'name' => '/^+*$/',
                    'hostname' => '/^[a-z0-9\.-_]+$/',
                    'port' => '/^[0-9]{2,5}$/',
                    'sshUsername' => '',
                    'home' => '',
                    'supervisorapiuser' => '',
                    'supervisorapipass' => '',
                    'supervisorapiport' => ''
            );
            $this->formdata = $_POST;

            $this->host->set($_POST);
        }


    }
}