<?php

namespace framework\helper;

use framework\manager;

/**
 * 联合Redis数据处理类
 *
 * @author shenzhe
 * @package framework\helper
 */
class QueueHelper {

    private static $cache = array();

    public static function getInstance($type = "redis", $name = "queue", $pconnect) {
        $cacheType = '\\framework\\helper\\queue\\' . $type . 'Helper';
        if (!isset(self::$cache[$cacheType])) {
            self::$cache[$cacheType] = new $cacheType($name, $pconnect);
        }
        return self::$cache[$cacheType];
    }

}
