<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Controller\ControllerAbstract;
use Mooshroom\Model\Hosts as HostModel;
use Mooshroom\Ssh;

class Hosts extends ControllerAbstract {

    public function indexAction() {
        $this->title = 'Hosts';
    }

}