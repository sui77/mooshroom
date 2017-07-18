<?php

namespace Mooshroom\Controller;

use Mooshroom\Model\Binaries;
use Mooshroom\Model\Server as MCServer;


class Server extends ControllerAbstract {

    /** @var  MCServer */
    public $server;

    public function init() {
        parent::init();
        $this->formdata = array(
            'memory' => '2048M',
            'name'   => '',
            'binary' => 'minecraft_server.1.8.jar'
        );

        $this->server = MCServer::getInstance($this->getParam('server'));
    }


    public function startAction() {
        $this->server->control('start');
        header('Location: ' . $_SESSION['lastUri']);
        exit();
    }

    public function stopAction() {
        $this->server->control('stop');
        header('Location: ' . $_SESSION['lastUri']);
        exit();
    }

    public function restartAction() {
        $this->server->control('restart');
        header('Location: ' . $_SESSION['lastUri']);
        exit();
    }

    public function createAction() {
        $this->binaries = Binaries::getAll('binaries');

        if (isset($_POST['name'])) {
            $this->formdata = $_POST;
            \Mooshroom\Model\Server::create($_POST['name'], $_POST);
            header('Location: /server/' . urlencode($_POST['name']) . '/general');
        }

    }

    public function accepteulaAction() {
        $this->server->acceptEula();
        header('Location: ' . $_SESSION['lastUri']);
        exit();
    }

    public function serverpropertiesAction() {

        if (isset($_POST['sp'])) {
            $this->server->set('restartneeded', 1);
            $this->server->getServerProperties()->set( $_POST['sp'] );

            if ($_POST['submit'] == 'Save and Restart') {
                $this->server->control('restart');
            }

            header('Location: /server/' . $this->server->getName() . '/serverproperties');
        }
    }

    public function whitelistAction() {
        if (isset($_POST['username'])) {
            $this->server->addWhitelist($_POST['username']);
            sleep(1);
            header('Location: /server/' . $this->server->getName() . '/whitelist');
        }
        if (isset($_GET['username'])) {
            $this->server->removeWhitelist($_GET['username']);
            sleep(1);
            header('Location: /server/' . $this->server->getName() . '/whitelist');
        }
    }

    public function opsAction() {
        if (isset($_POST['username'])) {
            $this->server->addOp($_POST['username'], $_POST['level']);
            sleep(1);
            header('Location: /server/' . $this->server->getName() . '/ops');
        }
        if (isset($_GET['username'])) {
            $this->server->removeOp($_GET['username']);
            sleep(1);
            header('Location: /server/' . $this->server->getName() . '/ops');
        }
    }

    public function indexAction() {

    }

    public function pluginsAction() {
    }

    public function switchpluginAction() {
        $this->server->set('restartneeded', 1);
        if ($_POST['checked'] == 'true') {
            $this->server->enablePlugin( $_POST['name'] );
        } else {
            $this->server->disablePlugin( $_POST['name'] );
        }
        exit('ok');
    }

    public function consoleAction() {
    }

    public function generalAction() {

        $this->binaries = Binaries::getAll('binaries');

        if (isset($_POST['action']) && $_POST['action'] == 'change') {
            $data = array(
                'jar' => $_POST['jar'],
                'memory' => $_POST['memory'],
            );
            $this->server->set($data);
            header('Location: /server/' . $this->server->getName() . '/general');
        } elseif (isset($_POST['action']) && $_POST['action'] == 'delete' && $_POST['confirm'] == 'delete') {
            $this->server->delete();
            header('Location: /');
        }


        $this->formdata = array(
            'name'   => $this->server->get('name'),
            'jar'    => $this->server->get('jar'),
            'memory' => $this->server->get('memory'),
        );
    }



    public function logoutAction() {
        User::getLoggedInUser()->setCookieAuthToken();
        User::getLoggedInUser()->logout();
        header('Location: /');
        exit();
    }

}