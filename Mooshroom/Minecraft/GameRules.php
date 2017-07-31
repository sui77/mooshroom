<?php

namespace Mooshroom\Minecraft;


use Mooshroom\Config;

class GameRules {

    private $_data = array();

    public function __construct($data = null) {
        $this->_data = json_decode( file_get_contents(BASE_PATH . '/config/gamerules.json'), 1);
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $this->_data[$k]['value'] = $v;
            }
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

    }


}