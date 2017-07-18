<?php

namespace Mooshroom;

abstract class XmlRpcAbstract {

    protected $_url = null;

    public function __construct($url)
    {
        $this->_url = $url;

        if (!function_exists('xmlrpc_encode_request')) {
            throw new \Exception('php-xmlrpc extension is not installed');
        }

        if (!function_exists('curl_init')) {
            throw new \Exception('php-curl extension is not installed');
        }
    }

    protected function executeRpcCall($method, $params)
    {
        if (count($params) == 0) {
            $params = array(null);
            $funcParams = array_merge(array($method), array_values($params));
            $postData = call_user_func_array('xmlrpc_encode_request', $funcParams);
        } else {
            $postData = xmlrpc_encode_request($method, $params);

        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $postData);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        $response = curl_exec($ch);
        if ($response === false) {
            $msg = 'POST error: ' . curl_error($ch);
            throw new \Exception($msg);
        }

        $responseDecoded = xmlrpc_decode($response);

        if (is_array($responseDecoded) && xmlrpc_is_fault($responseDecoded)) {
            $msg = 'XMLRPC fault: ' . $responseDecoded['faultString'] . ' (' . $responseDecoded['faultCode'] . ')';
           // throw new \Exception($msg);
        }

        return $responseDecoded;
    }
}