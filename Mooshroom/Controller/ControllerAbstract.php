<?php

namespace Mooshroom\Controller;


use Mooshroom\Config;
use Mooshroom\Model\Server;
use Mooshroom\Model\User;
use Mooshroom\Model\Hosts as HostModel;

abstract class ControllerAbstract {

    protected $_layout      = 'layout.phtml';
    protected $_maincontent = 'index.phtml';
    protected $_activeNav   = '';
    protected $_params      = array();
    protected $_viewparams  = array();
    protected $_startTime   = 0;

    public function __construct($params) {
        $this->_startTime = microtime(1);
        $this->_params = $params;
        $this->servers = Server::getAll();
        $this->hosts = HostModel::getAll();
    }

    protected function assign($key, $value) {
        $this->_viewparams[$key] = $value;
    }

    protected function getParam($key, $default = '') {
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        }
        return $default;
    }

    protected function init() {
        $this->_needAuth();
        $this->user = User::getLoggedInUser();

    }

    protected function _getNav() {

        $nav = $this->_nav = include Config::get('baseDir') . '/config/navigation.inc.php';
        foreach ($nav as &$v) {
            echo $v['name'] . ' ' . $this->_activeNav . '<br>';
            if ($v['name'] == $this->_activeNav) {
                $v['active'] = true;
            }
            if (isset($v['sub'])) {
                foreach ($v['sub'] as &$v2) {
                    if ($v2['name'] == $this->_activeNav) {
                        $v['active'] = $v2['active'] = true;
                    }
                }
            }
        }
        return $nav;
    }

    protected function _setActiveNav($name) {
        $this->_activeNav = $name;
    }

    protected function _needAuth() {
        if (isset($_POST['user'])) {
            if (User::login($_POST['user'], $_POST['pass'])) {
                header('Location: /');
            }
        }

        if (!User::getLoggedInUser()->isLoggedIn()) {
            header('403 Forbidden', true, 403);
            $this->_layout = '403.phtml';
            $this->render();
            exit();
        }
    }

    public function execute($action) {
        session_start();
        $this->init();

        $tmp = explode('\\', get_class($this));
        $this->_maincontent = $tmp[count($tmp)-1] . '/' . $action . '.phtml';

        call_user_func( array($this, $action . 'Action'));

        $this->render();
        $_SESSION['lastUri'] = $_SERVER['REQUEST_URI'];
    }

    protected function _isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    public function render() {

        foreach ($this->_viewparams as $k => $v) {
            $$k = $v;
        }

        $maincontent = dirname(__FILE__) . '/../Views/' . $this->_maincontent;
        $this->time = microtime(1) - $this->_startTime;
        if (isset($this->_layout) && !is_null($this->_layout)) {
            include dirname(__FILE__) . '/../Views/' . $this->_layout;
        } else {
            include $maincontent;
        }

    }

}