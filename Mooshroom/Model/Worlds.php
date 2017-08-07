<?php

namespace Mooshroom\Model;
use Mooshroom\Config;
use Mooshroom\Ssh;
use Mooshroom\SupervisorRpcClient;
use Predis\Client;

class Worlds extends KeyValueModelAbstract {

    protected static $_redisKey = 'mcadmin:worlds';
    private $_sshConnection = null;
    private $_supervisor;


}