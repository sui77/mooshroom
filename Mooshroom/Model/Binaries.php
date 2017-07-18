<?php

namespace Mooshroom\Model;

use Mooshroom\Config;
use Mooshroom\Ssh;

class Binaries {

    public static function getAll($type) {
        $d = Config::get('files.' . $type . '.localDir');
        if (empty($d)) {
            return array();
        }
        $dir = opendir( $d );
        $binaries = array();
        while ($f = readdir($dir)) {
            if (preg_match(Config::get('files.' . $type . '.type'), $f)) {
                $binaries[] = $f;
            }
        }
        asort($binaries);
        return $binaries;
    }

    public static function syncAll() {
        $config = Config::get('files');
        foreach ($config as $type => $egal) {
            self::sync($type);
        }
    }

    public static function sync($type) {
        $config = Config::get('files.' . $type);
        if (!isset($config['localDir'])) {
            exit('mööp');
        }
        $hosts = Hosts::getAll();
        foreach ($hosts as $h) {
            exec('rsync -e "ssh -i ' . Config::get('sshkey.private'). '" -avz ' . $config['localDir'] . '/ minecraft@' . $h->get('hostname') . ':' . $config['remoteDir'] . '/', $out, $err );
        }
    }
}