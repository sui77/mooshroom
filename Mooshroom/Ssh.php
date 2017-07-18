<?php

namespace Mooshroom;

class Ssh {

    private $_host;
    private $_port;
    private $_pubkeyfile;
    private $_privkeyfile;
    private $_passphrase;
    private $_lastError = '';


    public function getLastError() {
        return $this->_lastError;
    }

    public function __construct($host, $port, $auth) {
        $this->_connection = ssh2_connect($host, $port);
        if (!$this->_connection) {
            $this->_lastError = 'Connection failed to ' . $host . ':' . $port;
            return;
        }

        $ok = ssh2_auth_pubkey_file(
            $this->_connection,
            $auth['username'],
            $auth['public'],
            $auth['private'],
            $auth['passphrase']
        );
        if (!$ok) {
            $this->_lastError = 'Authentication failed for ' . $auth['username'] . '@' . $host . ':' . $port;
        }
    }

    public function ls($path) {
        $r = array();
        $result = $this->exec('ls ' . $path );
        $tmp = explode("\n", $result);
        foreach ($tmp as $line) {
            if (trim($line) != '') {
                $r[] = trim($line);
            }
        }
        return $r;
    }

    public function scpSend($src, $dst) {
        ssh2_scp_send($this->_connection, $src, $dst);
    }

    public function scpReceive($src, $dst) {
        ssh2_scp_recv($this->_connection, $src, $dst);
    }

    public function exec($cmd) {
        $stream = ssh2_exec($this->_connection, $cmd);
        if (!$stream) {
            $this->_lastError = 'Could not execute command';
            return;
        }

        stream_set_blocking($stream, true);

        $stdio_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $stderr_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

        $result = stream_get_contents($stdio_stream);
        $result_error = stream_get_contents($stderr_stream);

        if (!empty($result_error)) {
            $this->_lastError = $result_error;
        }

        fclose($stream);
        if (isset($stderr_stream)) {
            fclose($stderr_stream);
        }

        return $result;
    }
}