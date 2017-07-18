<?php
if (!file_exists('/etc/supervisor/supervisord.conf')) {
    echo json_encode( array('error' => "supervisor config not found.") );
    exit();
}
$f = file_get_contents('/etc/supervisor/supervisord.conf');
if (preg_match('/files\s+=\s+(.*)\n/si', $f, $m)) {
    $tmp = explode(' ', $m[1]);
    foreach ($tmp as $dir) {
        $dir = trim($dir);
        $d = opendir( dirname(trim($dir)) );
        while ($file = readdir($d)) {
            if (preg_match('/.conf$/', $file)) {
                $f .= "\n" . file_get_contents( dirname($dir) . '/' . $file );
            }
        }
    }
}

$tmp = explode("\n", $f);
$currentSection = 'none';
$config = array();
foreach ($tmp as $line) {
    $tmp2 = explode('=', $line);
    if (preg_match('/^\[(.*?)\]/', $line, $m)) {
        $currentSection = $m[1];
    } else if (count($tmp2) == 2) {
        $config[$currentSection][ trim($tmp2[0]) ] = trim($tmp2[1]);
    }
}
if (isset($config['inet_http_server'])) {
    echo json_encode($config['inet_http_server']);
} else {
    echo json_encode( array('error' => "supervisor rpc server config not found") );
}

