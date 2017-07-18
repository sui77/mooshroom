<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Model\User;
use Mooshroom\Ssh;

class Index extends ControllerAbstract {

    public function init() {
        parent::init();
    }

    public function indexAction() {

    }

    public function logoutAction() {
        User::getLoggedInUser()->setCookieAuthToken();
        User::getLoggedInUser()->logout();
        header('Location: /');
        exit();
    }

}