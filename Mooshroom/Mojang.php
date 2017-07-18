<?php
namespace Mooshroom;

use Predis\Client;

class Mojang {

    public static function getLatestServer() {
        $redis = new Client(Config::get('redis'));
        if (! ($versions = $redis->get('mcadmin:minecraft_version_manifest'))) {
            $versions = file_get_contents('https://launchermeta.mojang.com/mc/game/version_manifest.json');
            $redis->setex('mcadmin:minecraft_version_manifest', 60*60, $versions);

            $versions = json_decode($versions, 1);
            $source = 'https://s3.amazonaws.com/Minecraft.Download/versions/' . $versions['latest']['release'] . '/minecraft_server.' . $versions['latest']['release'] . '.jar';
            $target = Config::get('files.binaries.localDir') . '/minecraft_server.' . $versions['latest']['release'] . '.jar';
            if (!file_exists($target)) {
                copy($source, $target);
            }
        }
    }

    public static function getDownloadUrls() {
        $redis = new Client(Config::get('redis'));
        if (! ($versions = $redis->get('mcadmin:minecraft_version_manifest'))) {
            $versions = file_get_contents('https://launchermeta.mojang.com/mc/game/version_manifest.json');
            $redis->setex('mcadmin:minecraft_version_manifest', 60*60, $versions);
        }

        $versions = json_decode($versions, 1);
        $return = array();
        foreach ($versions['versions'] as $v) {
            if (in_array($v['type'], array('snapshot', 'release'))) {
                $return[$v['id']] = 'https://s3.amazonaws.com/Minecraft.Download/versions/' . $v['id'] . '/minecraft_server.' . $v['id'] . '.jar';
            }
        }
        return $return;

    }

    public static function getHead($uuid) {
        $uuid = str_replace('-', '', $uuid);

        $redis = new Client(Config::get('redis'));
        if (!$imgdata = $redis->hget('mcadmin:useravatar', $uuid)) {

            $skin = file_get_contents('https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid);
            $skin = json_decode($skin, 1);
            $skin = json_decode(base64_decode($skin['properties'][0]['value']), 1);
            $skin = $skin['textures']['SKIN']['url'];

            $im = imagecreatefrompng($skin);
            $im2 = imagecreatetruecolor(64 , 64);
            $multi = 8;
            $pos = array('left' => 8, 'top' => 8, 'width' => 8, 'height' => 8, 'dstLeft' => 0, 'dstTop' => 0);
            imagecopyresized($im2, $im, $multi * $pos['dstLeft'], $multi * $pos['dstTop'], $pos['left'], $pos['top'],$pos['width']*8, $pos['height']*8,$pos['width'], $pos['height']);

            ob_start();
            imagepng($im2);
            $imgdata = base64_encode(ob_get_clean() );


            $redis->hset('mcadmin:useravatar', $uuid, $imgdata);
        }

        return $imgdata;

    }
}
