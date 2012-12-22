<?php

namespace framework\helper\queue;

use framework\manager;

/**
 * 联合Redis数据处理类
 *
 * @author shenzhe
 * @package framework\helper
 */
class RedisHelper {

    private static $redis;

    public function __construct($name = "", $pconnect = false) {
        if (empty(self::$redis)) {
            self::$redis = manager\RedisManager::getInstance($name, $pconnect);
        }
    }

    public function addQueue($key, $data) {
        return self::$redis->rPush($key, \igbinary_serialize($data));
    }

    public function getQueue($key) {
        return \igbinary_unserialize(self::$redis->lPop($key));
    }

}
