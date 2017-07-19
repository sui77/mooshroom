<?php

namespace Mooshroom\Model;
use Mooshroom\Config;
use Mooshroom\Ssh;
use Mooshroom\SupervisorRpcClient;
use Predis\Client;

class Hosts extends KeyValueModelAbstract {

    protected static $_redisKey = 'mcadmin:hosts';
    private $_sshConnection = null;
    private $_supervisor;


    public function sshConnect() {
        if ($this->_sshConnection == null) {
            $auth = Config::get('sshkey');
            $auth['username'] = $this->get('sshUsername');
            $this->_sshConnection = new Ssh($this->get('hostname'), $this->get('port'), $auth);
        }
        return $this->_sshConnection;
    }

    public function scpSend($src, $dst) {
        $this->sshConnect()->scpSend($src, $dst);
    }

    public function scpReceive($src, $dst) {
        $this->sshConnect()->scpReceive($src, $dst);
    }

    public function ssh($cmd) {
        return $this->sshConnect()->exec($cmd);
    }

    public function ls($path) {
        return $this->sshConnect()->ls($path);
    }

    public function getSupervisor() {
        if (is_null($this->_supervisor)) {
            $this->_supervisor = new SupervisorRpcClient($this->get('supervisorapi'));
        }
        return $this->_supervisor;
    }
}