<?php

namespace Mooshroom;

use Mooshroom\Controller\Error;

class Router {

    private static $_instance;

    private $_routesConfig = array();

    private $_params = array();

    private function __construct() {
        $this->_routesConfig = include Config::get('baseDir') . '/config/routes.inc.php';
    }

    public function route($uri) {
        $tmp = explode('?', $uri);
        $path = explode('/', $tmp[0] );


        $currentRoute = '';

        foreach ($this->_routesConfig as $name => $route) {
            $routePath = explode('/', $route['url']);

            foreach ($routePath as $n => $sub) {

                if (substr($sub, 0, 1) != ':' && isset($path[$n]) && $sub != $path[$n]) {
                    break;
                } elseif (isset($path[$n]) && $sub == $path[$n] && $currentRoute == '') {
                    $currentRoute = $name;
                } elseif (substr($sub, 0, 1) == ':') {
                    if (isset($path[$n])) {
                        $this->_params[substr($sub, 1)] = $path[$n];
                    } else if (isset($route['defaults'][substr($sub, 1)])) {
                        $this->_params[substr($sub, 1)] = $route['defaults'][substr($sub, 1)];
                    }
                    $currentRoute = $name;
                }
            }
        }
        if ($currentRoute != null) {
            foreach ($this->_routesConfig[$currentRoute]['defaults'] as $k => $v) {
                if (!isset($this->_params[$k])) {
                    $this->_params[$k] = $v;
                }
            }
        } else {
            $this->_params['controller'] = 'Error';
            $this->_params['action'] = 'error404';
        }

        return $this;
    }

    public function xroute($uri) {
        $tmp = explode('?', $uri);

        foreach ($this->_routesConfig as $name => $route) {
            $regex = $route['regex'];
            if (preg_match( '/' . $regex . '/', $tmp[0], $m)) {
                $this->_params['controller'] = $route['controller'];
                if (isset($route['action'])) {
                    $this->_params['action'] = $route['action'];
                }

                array_shift($m);
                foreach ($route['params'] as $param) {
                    $this->_params[$param] = null;
                    if (count($m) > 0) {
                        $this->_params[$param] = urldecode(array_shift($m));
                    }
                }
                if (isset($route['activeNav'])) {
                    $this->_params['activeNav'] = $route['activeNav'];
                }
                return $this;
            }
        }
        return $this;
    }

    public function url($routeName, $params = array()) {
        return;
        $r = $this->_routesConfig[$routeName]['regex'];
        $r = stripslashes(preg_replace('/^\^|\$$/', '', $r));
        foreach ($params as $param) {
            $r = preg_replace('/\(.*?\)/', $param, $r);
        }
        echo $r;
        exit();
    }

    public function execute() {
        $controllerClass =  '\Mooshroom\Controller\\' . $this->_params['controller'];
        $action = $this->_params['action'];

        if (!class_exists($controllerClass)) {
            $controller = new Error( array('errormsg' => 'Unknown Controller ' . $controllerClass ));
            $action = 'error500';
        } else  if ( !method_exists($controllerClass, $action . 'Action')) {
            $controller = new Error( array('errormsg' => 'Unknown Action ' . $action . ' in ' . $controllerClass ));
            $action = 'error500';
        } else {
            $controller = new $controllerClass($this->_params);
        }


        $controller->execute($action);
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}