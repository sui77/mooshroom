<?php

namespace Mooshroom;

use Mooshroom\Model\Hosts;

class Configfiles {

    private $_host = null;
    private $_gameDir = '';

    public function __construct(Hosts $host, $gameDir) {
        $this->_host = $host;
        $this->_gameDir = $gameDir;
    }

    public function getFiles() {
        $configfiles = [];
        $files = $this->_host->ssh('du -a ' . $this->_gameDir);
        $files = explode("\n", $files);
        foreach ($files as $f) {
            if (preg_match('/\.yml|\.csv|\.properties|\.json$/', $f)) {
                $configfiles[] = explode('/', 'root' . preg_replace('/^[^\/]*/', '', trim(str_replace($this->_gameDir, '', $f))));
            }
        }

        $result = array();
        foreach ($configfiles as $cf) {

            $r = &$result;
            for ($i = 0; $i< count($cf)-1; $i++) {
                if (!isset($r[$cf[$i]])) {
                    $r[$cf[$i]] = array();
                }
                $r = &$r[$cf[$i]];
            }
            $r['###files'][] = $cf[ count($cf) -1 ];
        }

        return $result;

    }

    public function saveFile($f, $content) {

        $tmp = Config::get('tmpDir') . '/' . uniqid('conf');
        $fp = fopen($tmp, 'w');
        fputs($fp, $content);
        fclose($fp);
        echo $f;
        $this->_host->scpSend($tmp, $this->_gameDir . '/' . $f);

    }

    public function getFile($f) {
        if (!preg_match('/\.\./', $f)) {
            return $this->_host->ssh('cat ' . $this->_gameDir . '/' . $f);
        }
    }
}