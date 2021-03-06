<?php

return array(
    'baseUrl'    => '/',
    'baseDir'    => dirname(__FILE__) . '/../',
    'tmpDir'     => '/var/lib/mooshroom/tmp',
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