<?php

namespace Mooshroom\Controller;

use Mooshroom\Config;
use Mooshroom\Model\Binaries;
use Mooshroom\Model\User;
use Mooshroom\Mojang;
use Mooshroom\Ssh;

class Upload extends ControllerAbstract {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->files = \Mooshroom\Model\Binaries::getAll( $this->getParam('type') );
        //Binaries::syncAll();
    }

    public function uploadurlAction() {
        $url = $_POST['url'];
        $tmp = explode('/', $url);
        $filename = $tmp[ count($tmp) - 1];
        if (preg_match(Config::get('files.' . $this->getParam('type') . '.type'), $filename)) {
            $tmp = '/tmp/' . $filename;
            copy($url, $tmp);
            $host = \Mooshroom\Model\Hosts::getInstance('localhost');
            $host->scpSend($tmp, Config::get('files.' . $this->getParam('type') . '.localDir') . '/' . $filename );
            //Binaries::sync($this->getParam('type'));
            echo json_encode(
                array($filename)
            );
        }
        exit();
    }

    public function uploadAction() {

        $dir = Config::get('files.' . $this->getParam('type') . '.localDir');
        if (empty($dir)) {
            exit('invalid type');
        }

        if (file_exists($_FILES['files']['tmp_name'][0]) && preg_match(Config::get('files.' . $this->getParam('type') . '.type'), $_FILES['files']['name'][0] )) {

            @mkdir ($dir, 0777, true);

            move_uploaded_file( $_FILES['files']['tmp_name'][0], $dir . '/' . $_FILES['files']['name'][0] );
            //Binaries::sync( $this->getParam('type') );
            echo json_encode(
                array( $_FILES['files']['name'][0] )
            );
        }
        exit();
    }


}