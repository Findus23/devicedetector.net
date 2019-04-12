<?php

namespace DeviceDetectorNet;

use DeviceDetector\Cache\PSR6Bridge;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class CacheLoader {
    public $cache;

    public function __construct() {
        $redis = new \Redis();
        if (getenv("CI_JOB_ID")) {
            $redis->connect('redis');
        } else {
            $redis->connect('127.0.0.1');
        }
        $redis->select(9);
        $this->cache = new RedisAdapter($redis, 'device_detector_net');
    }

    public function configureDeviceDetector(\DeviceDetector\DeviceDetector &$dd) {
        $dd->setCache(
            new PSR6Bridge($this->cache)
        );

    }
}
