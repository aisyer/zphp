<?php

namespace framework\helper\cache;

/**
 * cache接口
 * @author shenzhe
 * @package framework\core
 */
interface ICacheHelper {

	//功能是否开启
    public function enable();  

    //添加
    public function add($key, $value);

    //设置
    public function set($key, $value);

    //获取
    public function get($key);

    //删除
    public function delete($key);

    //数字按step自增
    public function increment($key, $step = 1);

    //数字按step自减
    public function decrement($key, $step = 1);
}