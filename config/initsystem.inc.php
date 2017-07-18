<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '900M');
putenv('HOME=/var/www/');

require_once(BASE_PATH . '/vendor/autoload.php');
set_include_path( get_include_path() . PATH_SEPARATOR . BASE_PATH . '/Mooshroom/Views' );

spl_autoload_register ( function($class) {
    if (preg_match('/^Mooshroom/', $class)) {
        include_once(dirname(__FILE__) . '/../' . str_replace('\\', '/', $class) . '.php');
    }
});

