<?php

namespace Mooshroom;

use Predis\Client;

class JobQueue {

    private $_redis = null;

    public function __construct() {
        $this->_redis = new Client(Config::get('redis'));
    }

    public function getJob() {
        $job = $this->_redis->brpop('mcadmin:jobs', 10);
        return json_decode($job[1], 1);
    }

    public function addJob($job) {
        $this->_redis->lpush('mcadmin:jobs', json_encode($job) );
    }
}