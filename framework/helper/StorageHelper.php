<?php
namespace framework\helper;

use framework\manager;

/**
 * 联合Redis数据处理类
 *
 * @author shenzhe
 * @package framework\helper
 */
class StorageHelper
{
    private static $cache = array();

    public static function getInstance($type="redis", $name="storage", $pconnect=false)
    {
        $cacheType = '\\framework\\helper\\storage\\' . $type . 'Helper';
        if (!isset(self::$cache[$type.$name])) {
            self::$cache[$type.$name] = new $cacheType($name, $pconnect);
        }
        return self::$cache[$type.$name];
    }
}
