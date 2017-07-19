<?php

namespace Mooshroom\Model;

use Mooshroom\Config;
use Predis\Client;

abstract class KeyValueModelAbstract {

    private static $_instances = array();

    protected static $_redisKey = 'mcadmin:undefined';
    protected $_redis;

    public function get($key, $default = '') {
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    /**
     * @return null|string
     */
    public function getName() {
        return $this->_name;
    }

    public function set($key, $value = null) {
        if (!is_array($key)) {
            $tmp = array();
            $tmp[$key] = $value;
            $key = $tmp;
        }
        $redis = new Client(Config::get('redis'));
        foreach ($key as $k => $v) {
            if (!isset($this->_data[$k]) || $this->_data[$k] != $v) {
                $this->_data[$k] = $v;
                $redis->hset(static::$_redisKey . ':' . $this->getName(), $k, $v);
                $m = 'onChange_' . $k;
                if (method_exists($this, $m)) {
                    $this->$m($v);
                }
            }
        }
    }

    protected function __construct($_name) {
        $this->_name = $_name;
        $this->_redis = new Client( Config::get('redis') );
        $this->reload();
    }

    public function reload() {
        if ($this->_data = $this->_redis->hgetall(static::$_redisKey . ':' . $this->getName())) {
            return;
        }
        $this->_name = null;
    }

    public function delete() {
        $this->_redis->srem(static::$_redisKey, $this->getName() );
        $this->_redis->del(static::$_redisKey . ':' . $this->getName() );
    }

    public static function create($name, $data = null) {
        if (! ($s = static::getInstance($name))) {

            $redis = new Client(Config::get('redis'));
            $id = $redis->hincrby('IDs', static::$_redisKey, 1);
            $redis->sadd(static::$_redisKey, $name);
            $redis->hset(static::$_redisKey . ':' . $name, 'name', $name);
            $redis->hset(static::$_redisKey . ':' . $name, 'id', $id);
            $s = static::getInstance($name);

            if (is_array($data)) {
                foreach ($data as $k => $v) {
                    $s->set($k, $v);
                }
            }
        }
        return $s;
    }


    /**
     * @param $name
     * @return $this
     */
    public static function getInstance($name) {
        $key = get_called_class() . '_' . $name;
        if (!isset(self::$_instances[$key])) {
            $i = new static($name);
            if ($i->getName() === null) {
                return false;
            }
            self::$_instances[$key] = $i;
        }

        return self::$_instances[$key];
    }

    public static function getAll() {
        $r = new Client(Config::get('redis'));
        $all = $r->smembers(static::$_redisKey);
        sort($all);
        $return = array();
        foreach ($all as $a) {
            $return[] = static::getInstance($a);
        }
        return $return;
    }
}