<?php

return array(
    'baseDir'    => dirname(__FILE__) . '/../',
    'gameDir' => '/home/minecraft',
    'admin' => array(
        'user' => 'user',
        'pass' => 'testtest',
    ),
    'sshkey' => array(
        'username'   => 'minecraft',
        'public'     => dirname(__FILE__) . '/sshkey/id_rsa.pub',
        'private'    => dirname(__FILE__) . '/sshkey/id_rsa',
        'passphrase' => '',
    ),
    'files' => array(
        'binaries' => array(
            'type' => '/\.jar$/',
            'localDir'  => dirname(__FILE__) . '/../upload/binaries',
            'remoteDir' => '/home/minecraft/mcadmin_files/binaries',
        ),
        'plugins' => array(
            'type' => '/\.jar$/',
            'localDir'  => dirname(__FILE__) . '/../upload/plugins',
            'remoteDir' => '/home/minecraft/mcadmin_files/plugins',
        ),
        'schematics' => array(
            'type' => '/\.schematic/',
            'localDir'  => dirname(__FILE__) . '/../upload/schematics',
            'remoteDir' => '/home/minecraft/mcadmin_files/schematics',
        ),
    )
);