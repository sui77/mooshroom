<?php

$extensions = array(
    'gdlib' => '',
);

foreach ($extensions as $name => $description) {
    if (!extension_loaded($name)) {
        echo 'Missing php extension: ' . $name . '<hr>';
    }
}