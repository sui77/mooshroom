<?php

namespace Mooshroom\Model;

use Mooshroom\Config;
use Predis\Client;

class User {

    private static $_instances = array();

    private $_userName = 'none';

    private function __construct($username) {
        $this->_userName = strtolower($username);
        $this->_redis = new Client( Config::get('redis') );
        $this->reload();
    }

    public function reload() {
        $this->_data = $this->_redis->hgetall('user:' . $this->_userName);
    }

    public static function login($user, $pass) {
        $user = strtolower($user);

        if ($user == Config::get('admin.user') && $pass == Config::get('admin.pass')) {
            $userObj = User::getInstance($user);
            $_SESSION['userName'] = $userObj->getUsername();
            $userObj->setWebsocketToken();
            return self::getInstance($userObj->getUsername());
        } else {
            return false;
        }
    }

    public function setCookieAuthToken() {
        $auth = sha1( $this->getUserName() . time() . uniqid('asdf'));
        $this->_redis->hset('user:' . $this->getUserName(), 'cookieAuth', $auth);
        return sha1($auth);
    }

    public function verifyCookieAuthToken($token) {
        $tokenDb = $this->_redis->hget('user:' . $this->getUserName(),  'cookieAuth');
        return (!empty($tokenDb) && sha1($tokenDb) == $token);
    }

    public static function logout() {
        $_SESSION = array();
        session_destroy();
    }

    public function getUserName() {
        return $this->_userName;
    }

    public function getWebsocketToken() {
        if ($tmp = $this->_redis->lrange('user:' . $this->getUserName() . ':auth', 0, 1)) {
            return $tmp[0];
        }
    }

    public function setWebsocketToken() {
        $rKey = 'user:' . $this->getUserName() . ':auth';
        $n = $this->_redis->lpush($rKey, md5(uniqid('x').time()));
        if ($n > 3) {
            $this->_redis->rpop($rKey);
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['userName']) && ($this->getUserName() === $_SESSION['userName']);
    }

    /**
     * @return User
     */
    public static function getLoggedInUser() {
        if (isset($_SESSION['userName'])) {
            return self::getInstance( $_SESSION['userName'] );
        }
        return self::getInstance( 'none' );
    }

    /**
     * @param $username
     * @return User
     */
    public static function getInstance($username) {
        if (!isset(self::$_instances[$username])) {
            self::$_instances[$username] = new self($username);
        }
        return self::$_instances[$username];
    }

    public static function getAll() {
        $r = new Client(Config::get('redis'));
        $all = $r->smembers('users');
        sort($all);
        $return = array();
        foreach ($all as $a) {
            $return[] = User::getInstance($a);
        }
        return $return;
    }
}