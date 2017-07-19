<?php

return array(
    'baseDir'    => dirname(__FILE__) . '/../',
    'gameDir' => '/home/minecraft',
    'admin' => array(
        'user' => 'user',
        'pass' => 'testtest',
    ),
    'sshkey' => array(
        'public'     => '/var/lib/mooshroom/sshkeys/id_rsa_www-data.pub',
        'private'    => '/var/lib/mooshroom/sshkeys/id_rsa_www-data',
        'passphrase' => '',
    ),
    'files' => array(
        'binaries' => array(
            'type' => '/\.jar$/',
            'localDir'  => '/var/lib/mooshroom/files/jar',
            'remoteDir' => '/var/lib/mooshroom/files/jar',
        ),
        'plugins' => array(
            'type' => '/\.jar$/',
            'localDir'  => '/var/lib/mooshroom/files/plugins',
            'remoteDir' => '/var/lib/mooshroom/files/plugins',
        ),
        'schematics' => array(
            'type' => '/\.schematic/',
            'localDir'  => '/var/lib/mooshroom/files/schematics',
            'remoteDir' => '/var/lib/mooshroom/files/schematics',
        ),
    )
);