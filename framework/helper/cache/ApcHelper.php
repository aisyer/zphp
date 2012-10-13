<?php
namespace framework\helper\cache;

/**
 * 联合Redis数据处理类
 *
 * @author shenzhe
 * @package framework\helper
 */
class ApcHelper implements ICacheHelper
{
    public function __construct($name="", $pconnect="")
    {
    }

    public function enable()
    {
        return \function_exists('apc_add');
    }

    public function add($key, $value, $timeOut = 0)
    {
        return \apc_add($key, $value, $timeOut);
    }

    public function set($key, $value, $timeOut = 0)
    {
        return \apc_store($key, $value, $timeOut);
    }

    public function get($key)
    {
        return \apc_fetch($key);
    }

    public function delete($key)
    {
        return \apc_delete($key);
    }

    public function increment($key, $step = 1)
    {
        return \apc_inc($key, $step);
    }

    public function decrement($key, $step = 1)
    {
        return \apc_dec($key, $step);
    }


}
