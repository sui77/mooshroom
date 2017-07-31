<?php

define ('BASE_PATH', realpath(dirname(__FILE__) . '/../') );

include BASE_PATH . '/config/initsystem.inc.php';

$router = new \Mooshroom\Router( );
$router->route($_SERVER['REQUEST_URI'])->execute();