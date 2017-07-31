<?php

namespace Mooshroom;

use Mooshroom\Controller\Error;

class Router {

    private $_routesConfig = array();

    private $_params = array(
        'controller' => 'Error',
        'action' => 'error404',
    );

    public function __construct() {
        $this->_routesConfig = include Config::get('baseDir') . '/config/routes.inc.php';
    }


    public function route($uri) {
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

}