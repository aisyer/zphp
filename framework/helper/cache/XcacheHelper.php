<?php
namespace framework\helper\cache;

/**
 * 联合Redis数据处理类
 *
 * @author shenzhe
 * @package framework\helper
 */
class XcacheHelper implements ICacheHelper
{
    public function __construct($name="")
    {
    }

    public function enable()
    {
        return \function_exists('xcache_set');
    }

    public function add($key, $value, $timeOut = 0)
    {
        if (\xcache_isset($key)) {
            return false;
        }

        return \xcache_set($key, $value, $timeOut);
    }

    public function set($key, $value, $timeOut = 0)
    {
        return \xcache_set($key, $value, $timeOut);
    }

    public function get($key)
    {
        return \xcache_get($key);
    }

    public function delete($key)
    {
        return \xcache_unset($key);
    }

    public function increment($key, $step = 1)
    {
        return \xcache_inc($key, $step);
    }

    public function decrement($key, $step = 1)
    {
        return \xcache_dec($key, $step);
    }


}
