<?php

namespace Mooshroom\Controller;

use Mooshroom\Model\User;

class Index extends ControllerAbstract {

    public function init() {
        parent::init();
    }

    public function logoutAction() {
        User::getLoggedInUser()->setCookieAuthToken();
        User::getLoggedInUser()->logout();
        header('Location: /');
        exit();
    }

}