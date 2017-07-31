<?php

return
    array(
        array(
            'name'   => 'mcserver',
            'url'    => '/server',
            'title'  => 'Minecraft Server',
            'active' => false,
            'icon'   => 'ti-server',
        ),
        array(
            'name'  => 'hosts',
            'url'   => '/hosts',
            'title' => 'Hosts',
            'active' => false,
            'icon'   => 'ti-harddrives',
        ),
        array(
            'name' => 'library',
            'url'   => '#nav-library',
            'title' => 'Library',
            'active' => false,
            'icon'   => 'ti-folder',
            'sub'    => array(
                array(
                    'name'  => 'binaries',
                    'url'   => '/upload/index/binaries',
                    'title' => 'Binaries',
                    'active' => false,
                ),
                array(
                    'name'  => 'plugins',
                    'url'   => '/upload/index/plugins',
                    'title' => 'Plugins',
                    'active' => false,
                ),
                array(
                    'name'  => 'schematics',
                    'url'   => '/upload/index/schematics',
                    'title' => 'Schematics',
                    'active' => false,
                ),
            ),
        )
    );