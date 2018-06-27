<?php
$type = $argv[1];
$sec = (int) $argv[2];
$id = $argv[3];
require __DIR__ . '/../vendor/autoload.php';

/** @var  \Pasync\Adapter\RedisAdapter */
$redis = new \Pasync\Adapter\RedisAdapter();

sleep($sec);
// done

$res = $redis->getResTpl();
switch ($type) {
    case 'error':
        $res['done'] = false;
        $res['error'] = 'shit ' . microtime();
        break;
    case 'good':
    default:
        $res['done'] = true;
        $res['response'] = 'cool ' . microtime();
        break;
}

$redis->set($id, json_encode($res));