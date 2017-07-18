<?php

namespace Mooshroom;

class Config {

    private static $_config = null;

    public static function get($key, $config = null) {
        if (is_null(self::$_config)) {
            self::_initConfig();
        }
        if (is_null($config)) {
            $config = &self::$_config;
        }
        if (!is_array($key)) {
            $key = explode('.', $key);
        }
        if (count($key) == 0) {
            return $config;
        }

        $current = array_shift($key);
        if (isset($config[$current])) {
            return self::get($key, $config[$current]);
        }
    }

    public static function _initConfig() {
        self::$_config = include BASE_PATH . '/config/config.inc.php';
    }
}