<?php

namespace Mooshroom\Controller;

class Error extends ControllerAbstract {

    public function init() {
        parent::init();
        $this->assign('errormsg', $this->getParam('errormsg'));
    }

    public function error404Action() {
        header('404 Not found', true, 404);
    }

    public function error500Action() {
        header('500 Internal server error', true, 500);
    }
}