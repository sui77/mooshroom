<?php

namespace Mooshroom\Minecraft;


use Mooshroom\Config;

class ServerProperties {

    private $_file;
    private $_origFile;
    private $_data = array();
    private $_ssh = null;

    public function __construct($file, $ssh = null) {
        $this->_data = json_decode( file_get_contents(BASE_PATH . '/config/properties.en.json'), 1);
        $this->_file = $file;
        $this->_origFile = $file;
        $this->_ssh = $ssh;

        if ($ssh != null) {
            $this->_file = Config::get('tmpDir') . '/' . md5($file);
            $this->_ssh->scpReceive($this->_origFile, $this->_file);
        }

        if (file_exists($file)) {
            $this->_parse();
        }
    }

    public function getData() {
        return $this->_data;
    }

    public function get($key) {
        if ($this->_data[$key]['type'] == 'boolean') {
            return $this->_data[$key]['value'] === 'true';
        }
        return $this->_data[$key]['value'];
    }

    public function set($key, $value = null) {
        if (is_array($key) && is_null($value)) {
            foreach ($key as $k => $v) {
                $this->_data[$k]['value'] = $v;
            }
        } else {
            $this->_data[$key]['value'] = $value;
        }
        $this->_write();
    }

    private function _write() {
        $fp = fopen($this->_file, 'w');
        fputs($fp, "#Minecraft server properties\n");
        fputs($fp, "#" . date('r') . "\n");
        foreach ($this->_data as $key => $value) {
            fputs($fp, $key . '=' . $value['value'] . "\n");
        }
        fclose($fp);

        if ($this->_file != $this->_origFile) {
            $this->_ssh->scpSend($this->_file, $this->_origFile);
        }
    }

    private function _parse() {
        $f = file($this->_file);
        foreach ($f as $line) {
            if (!empty($line) && !preg_match('/$\s+#/', $line)) {
                $tmp = array();
                if ($tmp = explode('=', $line) ) {
                    if (!preg_match('/^#/', $line)) {
                        if (!isset($this->_data[trim($tmp[0])])) {
                            $this->_data[trim($tmp[0])] = array('type' => 'string', 'en' => 'unknown', 'de' => 'unbekannt', 'default' => '');
                        }
                        if (count($tmp) > 1) {
                            $this->_data[trim($tmp[0])]['value'] = trim($tmp[1]);
                        }
                    }
                }
            }
        }
    }
}