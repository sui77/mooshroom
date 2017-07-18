<?php

namespace Mooshroom\Model;
use Mooshroom\Config;
use Mooshroom\SupervisorRpcClient;
use Predis\Client;

class Hosts extends KeyValueModelAbstract {

    protected static $_redisKey = 'mcadmin:hosts';
    private $_supervisor;


    public function getSupervisor() {
        if (is_null($this->_supervisor)) {
            $this->_supervisor = new SupervisorRpcClient($this->get('supervisorapi'));
        }
        return $this->_supervisor;
    }
}