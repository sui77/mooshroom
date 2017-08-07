<?php

namespace Mooshroom\Model;

use Mooshroom\Config;
use Predis\Client;

abstract class KeyValueModelAbstract {

    private static $_instances = array();

    protected static $_redisKey = 'mcadmin:undefined';
    protected $_redis;
    protected $_id;

    public function get($key = null, $default = '') {
        if ($key == null) {
            return $this->_data;
        }
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    /**
     * @return null|string
     */
    public function getName() {
        return $this->get('name');
    }

    public function getId() {
        return $this->_id;
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
                $redis->hset(static::$_redisKey . ':' . $this->getId(), $k, $v);
                $m = 'onChange_' . $k;
                if (method_exists($this, $m)) {
                    $this->$m($v);
                }
            }
        }
    }

    protected function __construct($_id) {
        $this->_id = $_id;
        $this->_redis = new Client( Config::get('redis') );
        $this->reload();
    }

    public function reload() {
        if ($this->_data = $this->_redis->hgetall(static::$_redisKey . ':' . $this->getId())) {
            return;
        }
        $this->_name = null;
    }

    public function delete() {
        $this->_redis->srem(static::$_redisKey, $this->getId() );
        $this->_redis->del(static::$_redisKey . ':' . $this->getId() );
    }

    public static function create($name, $data = null) {


            $redis = new Client(Config::get('redis'));
            $id = $redis->hincrby('IDs', static::$_redisKey, 1);
            $redis->sadd(static::$_redisKey, $id);
            $redis->hset(static::$_redisKey . ':' . $id, 'name', $name);
            $redis->hset(static::$_redisKey . ':' . $id, 'id', $id);
            $s = static::getInstance($id);

            if (is_array($data)) {
                foreach ($data as $k => $v) {
                    $s->set($k, $v);
                }
            }

        return $s;
    }


    /**
     * @param $name
     * @return $this
     */
    public static function getInstance($id) {

        $key = get_called_class() . '_' . $id;
        if (!isset(self::$_instances[$key])) {
            $i = new static($id);
            if ($i->getId() === null) {
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