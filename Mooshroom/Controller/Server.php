<?php

namespace Mooshroom\Controller;

use Mooshroom\Model\Binaries;
use Mooshroom\Model\Server as MCServer;


class Server extends ControllerAbstract {

    /** @var  \Mooshroom\Model\Server */
    public $server;

    public function init() {
        parent::init();
        $this->formdata = array(
            'memory' => '2048M',
            'name'   => '',
            'binary' => 'minecraft_server.1.8.jar'
        );

        $this->server = MCServer::getInstance($this->getParam('server'));
        if ($this->server) {
            $this->title = $this->server->getName();
        }

        $this->_setActiveNav('mcserver');
    }


    public function startAction() {
        $this->server->control('start');
        exit();
    }

    public function stopAction() {
        $this->server->control('stop');
        exit();
    }

    public function restartAction() {
        $this->server->control('restart');
        exit();
    }

    public function createAction() {
        $this->title = 'Create a new minecraft server';

        $this->binaries = Binaries::getAll('binaries');

        if (isset($_POST['name'])) {
            $this->formdata = $_POST;
            $s = \Mooshroom\Model\Server::create($_POST['name'], $_POST);

            header('Location: /server/' . $s->getId() . '/general');
        }

    }

    public function accepteulaAction() {
        $this->server->acceptEula();
        header('Location: /server/' . $this->server->getId() . '/general');
        exit();
    }

    public function serverpropertiesAction() {

        if (isset($_POST['sp'])) {
            $this->server->set('restartneeded', 1);
            $this->server->getServerProperties()->set( $_POST['sp'] );
            header('Location: /server/' . $this->server->getId() . '/serverproperties');
        }
    }

    public function gamerulesAction() {
        if (isset($_POST['action'])) {
            $this->server->cmd( 'gamerule ' . $_POST['key'] . ' ' . $_POST['value'] );
            echo "X";
            echo '/gamerule ' . $_POST['key'] . ' ' . $_POST['value'];
            exit();
        }
    }

    public function whitelistAction() {
        if (isset($_POST['username'])) {
            $this->server->addWhitelist($_POST['username']);
            exit();
        }
        if (isset($_GET['username'])) {
            $this->server->removeWhitelist($_GET['username']);
            exit();
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
        $this->title = 'Minecraft Server';

    }

    public function pluginsAction() {
    }

    public function pluginscAction() {
        $cf = $this->server->getConfigfiles();

        if (isset($_POST['content'])) {
            $cf->saveFile($_GET['f'], $_POST['content']);
        }

        if (isset($_GET['f'])) {
            $this->fileToEdit = $cf->getFile( $_GET['f'] );
        }

    }

    public function addpluginAction() {
        $this->server->addPlugin($_POST['name']);
        exit('ok');
    }

    public function removepluginAction() {
        $this->server->removeplugin($_POST['name']);
        exit('ok');
    }

    public function switchpluginAction() {
        $this->server->set('restartneeded', 1);
        if ($_POST['value'] == 'true') {
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