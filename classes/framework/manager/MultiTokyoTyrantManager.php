<?php

namespace framework\manager;

/**
 * 联合TokyoTyrant管理工具
 *
 * @author zivn
 * @package framework\manager
 */
class MultiTokyoTyrantManager {

    /**
     * 联合TokyoTyrant配置
     *
     * @var <MultiTokyoTyrantConfiguration>array
     */
    private static $configs;

    /**
     * 联合TokyoTyrant实例
     *
     * @var array
     */
    private static $instances;

    /**
     * 添加联合TokyoTyrant配置
     *
     * @param int $poolIndex
     * @param TokyoTyrantConfiguration $config
     */
    public static function addConfigration($config) {
        self::$configs[$config['rate']] = $config;
        krsort(self::$configs);
    }

    /**
     * 获取信息散列后对应的服务器组索引
     *
     * @param string $userId
     * @return int
     */
    public static function getPoolIndex($userId) {
        $hashIndex = sprintf('%u', crc32($userId) >> 16 & 0xffff) % 128;
        $poolIndexs = array_keys(self::$configs);

        foreach ($poolIndexs as $poolIndex) {
            if ($hashIndex >= $poolIndex) {
                return $poolIndex;
            }
        }

        return null;
    }

    /**
     * 获取TokyoTyrant实例
     *
     * @param string $userId
     * @return <\TokyoTyrant>array
     */
    public static function getInstance($userId) {
        $poolIndex = self::getPoolIndex($userId);
        return self::$configs[$poolIndex];
    }

}