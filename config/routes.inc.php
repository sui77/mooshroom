<?php

return array(

    'home' => array(
        'url' => '/',
        'defaults' => array(
            'controller' => 'Server',
            'action' => 'index',
        )
    ),

    'hosts_action' => array(
        'url' => '/hosts/:hostname/:action',
        'defaults' => array(
            'controller' => 'Hosts',
            'action' => 'index',
        )
    ),

    'hosts' => array(
        'url' => '/hosts',
        'action' => 'index',
        'defaults' => array(
            'controller' => 'Hosts',
            'action' => 'index',
        )
    ),

    'worlds_action' => array(
        'url' => '/worlds/:action',
        'defaults' => array(
            'controller' => 'Worlds',
            'action' => 'index',
        )
    ),


    'upload' => array(
        'url' => '/upload/:action/:type',
        'defaults' => array(
            'controller' => 'Upload',
            'action' => 'index',
        )
    ),





    'server_delete' => array(
        'url' => '/server/delete/:server/:token',
        'defaults' => array(
            'controller' => 'Server',
            'action' => 'index',
        )
    ),

    'server_action' => array(
        'url' => '/server/:server/:action',
        'defaults' => array(
            'controller' => 'Server',
            'action' => 'index',
        )
    ),



    'ajax' => array(
        'url' => '/ajax/:action',
        'defaults' => array(
            'controller' => 'Ajax',
            'action' => 'index',
        )
    ),

    'api' => array(
        'url' => '/api/:action',
        'defaults' => array(
            'controller' => 'Api',
            'action' => 'index',
        )
    ),

    'logout' => array(
        'url' => '/logout',
        'defaults' => array(
            'controller' => 'Index',
            'action' => 'logout',
        )
    )
);