<?php

return array(

    '^\/$' => array(
        'controller' => 'Index',
        'action' => 'index',
        'params' => array(),
    ),

    '^\/hosts\/(.*)' => array(
        'controller' => 'Hosts',
        'params' => array('action'),
    ),

    '^\/hosts' => array(
        'controller' => 'Hosts',
        'action' => 'index',
        'params' => array(),
    ),


    '^\/upload\/(.*)\/(.*)' => array(
        'controller' => 'Upload',
        'params' => array('action', 'type'),
    ),



    '^\/server\/add' => array(
        'controller' => 'Server',
        'action' => 'create',
        'params' => array(),
    ),

    '^\/server\/delete\/(.*)\/(.*)' => array(
        'controller' => 'Server',
        'action' => 'delete',
        'params' => array('server', 'token'),
    ),

    '^\/server\/(.*)\/(.*)' => array(
        'controller' => 'Server',
        'params' => array('server', 'action'),
    ),

    '^\/server' => array(
        'controller' => 'Server',
        'action' => 'index',
        'params' => array(),
    ),

    '^\/ajax\/(.*)' => array(
        'controller' => 'Ajax',
        'params' => array('action'),
    ),

    '^\/logout' => array(
        'controller' => 'Index',
        'action' => 'logout',
        'params' => array(),
    )
);