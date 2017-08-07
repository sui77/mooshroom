<?php

namespace Mooshroom;

class SupervisorRpcClient extends XmlRpcAbstract {

    private $_allProcessInfo = null;

    public function getAllProcessInfo() {
        return $this->executeRpcCall('supervisor.getAllProcessInfo', array());
    }

    public function reloadConfig() {
        return $this->executeRpcCall('supervisor.reloadConfig', array());
    }

    public function addProcessGroup($name) {
        $this->executeRpcCall('supervisor.reloadConfig', array());
        try {
            return $this->executeRpcCall('supervisor.addProcessGroup', array($name));
        }  catch (\Exception $e) {
            // todo...
        }
    }

    public function getProcessInfo($name, $reload = false) {

        if ($reload || !isset($this->_allProcessInfo)) {
            $tmp = $this->getAllProcessInfo();
            foreach ($tmp as $l) {
                $this->_allProcessInfo[$l['name']] = $l;
            }
        }
        return $this->_allProcessInfo[$name];
    }

    public function removeProcessGroup($name) {
        return $this->executeRpcCall('supervisor.removeProcessGroup', array($name));
    }

    public function stopProcess($name) {
        try {
            return $this->executeRpcCall('supervisor.stopProcess', array($name));
        } catch (\Exception $e) {
            // not running, nevermind
        }
    }

    public function startProcess($name) {
        return $this->executeRpcCall('supervisor.startProcess', array($name));
    }

    public function sendProcessStdin($name, $chars) {
        if (!preg_match('/\n$/', $chars)) {
            $chars .= "\n";
        }
        return $this->executeRpcCall('supervisor.sendProcessStdin', array($name, $chars));
    }

}