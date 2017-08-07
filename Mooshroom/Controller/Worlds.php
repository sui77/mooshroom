<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Controller\ControllerAbstract;
use Mooshroom\Model\Hosts as HostModel;
use Mooshroom\Router;
use Mooshroom\Ssh;

class Worlds extends ControllerAbstract {

    public function init() {
        parent::init();
        $this->_setActiveNav('worlds');
    }

    public function indexAction() {
        $this->title = 'Worlds';
        Router::getInstance()->url('worlds_action', array());
    }

    public function detailAction() {
        $this->title = 'Worlds &gt; ';
    }

    public function createAction() {
        $this->title = 'Worlds &gt; Create New';
    }
}