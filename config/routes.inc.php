<?php

return array(

    'home' => array(
        'regex' => '^\/$',
        'controller' => 'Server',
        'action' => 'index',
        'params' => array(),
    ),

    'hosts_action' => array(
        'regex' => '^\/hosts\/(.*)',
        'controller' => 'Hosts',
        'params' => array('action'),
    ),

    'hosts' => array(
        'regex' => '^\/hosts',
        'controller' => 'Hosts',
        'action' => 'index',
        'params' => array(),
    ),


    'upload' => array(
        'regex' =>  '^\/upload\/(.*)\/(.*)',
        'controller' => 'Upload',
        'params' => array('action', 'type'),
    ),



    'server_add' => array(
        'regex' => '^\/server\/add',
        'controller' => 'Server',
        'action' => 'create',
        'params' => array(),
    ),

    'server_delete' => array(
        'regex' => '^\/server\/delete\/(.*)\/(.*)',
        'controller' => 'Server',
        'action' => 'delete',
        'params' => array('server', 'token'),
    ),

    'server_action' => array(
        'regex' => '^\/server\/(.*)\/(.*)',
        'controller' => 'Server',
        'params' => array('server', 'action'),
    ),

    'server' => array(
        'regex' => '^\/server',
        'controller' => 'Server',
        'action' => 'index',
        'params' => array(),
    ),

    'ajax' => array(
        'regex' => '^\/ajax\/(.*)',
        'controller' => 'Ajax',
        'params' => array('action'),
    ),

    'api' => array(
        'regex' => '^\/api\/(.*)',
        'controller' => 'Api',
        'params' => array('action'),
    ),

    'logout' => array(
        'regex' => '^\/logout',
        'controller' => 'Index',
        'action' => 'logout',
        'params' => array(),
    )
);