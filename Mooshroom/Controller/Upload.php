<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Model\Binaries;
use Mooshroom\Model\User;
use Mooshroom\Mojang;
use Mooshroom\SpigetAPI;
use Mooshroom\Ssh;

class Upload extends ControllerAbstract {


    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->files = \Mooshroom\Model\Binaries::getAll( $this->getParam('type') );
        $this->title = ucfirst( $this->getParam('type') );
    }

    public function spigetAction() {
        header('Content-type: text/json');
        $f = SpigetAPI::downloadResource($_POST['id']);
        if (!empty(SpigetAPI::$lastFilename)) {

            $filename = SpigetAPI::$lastFilename;

            $tmp = Config::get('tmpDir') . '/' . $filename;
            $fp = fopen( $tmp, 'w');
            fputs($fp, $f);
            fclose($fp);

            $host = \Mooshroom\Model\Hosts::getInstance('localhost');
            $host->scpSend($tmp, Config::get('files.plugins.localDir') . '/' . $filename );


        }


        echo json_encode( array(SpigetAPI::$lastFilename) );
        exit();
    }

    public function uploadurlAction() {
        header('Content-type: text/json');
        $url = $_POST['url'];
        $tmp = explode('/', $url);
        $filename = $tmp[ count($tmp) - 1];

        if (false && preg_match(Config::get('files.' . $this->getParam('type') . '.type'), $filename)) {
            $tmp = Config::get('tmpDir') . '/' . $filename;
            copy($url, $tmp);


            $host = \Mooshroom\Model\Hosts::getInstance('localhost');
            $host->scpSend($tmp, Config::get('files.' . $this->getParam('type') . '.localDir') . '/' . $filename );
            echo json_encode(
                array($filename)
            );
        } else {
            echo json_encode(
                array('error' => 'Invalid file')
            );
        }
        exit();
    }

    public function uploadAction() {
        header('Content-type: text/json');
        $dir = Config::get('files.' . $this->getParam('type') . '.localDir');
        if (empty($dir)) {
            exit('invalid type');
        }

        if (file_exists($_FILES['files']['tmp_name'][0]) && preg_match(Config::get('files.' . $this->getParam('type') . '.type'), $_FILES['files']['name'][0] )) {
            \Mooshroom\Model\Hosts::getInstance('localhost')->scpSend( $_FILES['files']['tmp_name'][0], Config::get('files.' . $this->getParam('type') . '.localDir') . '/' . $_FILES['files']['name'][0]);

            echo json_encode(
                array( $_FILES['files']['name'][0] )
            );
        }
        exit();
    }


}