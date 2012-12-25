<?php

namespace framework\helper\storage;

/**
 * storage接口
 *
 * @author shenzhe
 * @package framework\helper\storage
 */
interface IStorage {

    //设置从库
    public function setSlave($name);

    //批量获取 (先从mem取，取不到从disk取)
    public function getMutilMD($userId, $keys);

    //获取 (先从mem取，取不到从disk取)
    public function getMD($userId, $key, $slaveName = "");

    //获取 (只从disk取)
    public function getSD($userId, $key, $slaveName = "");

    //存入数据 (同是存me和disk)
    public function setMD($userId, $key, $data);

    //批量存入数据 (同是存me和disk)
    public function setMultiMD($userId, $keys);

    //删除数据 (同是删除me和disk)
    public function del($userId, $key);

    //设置过期时间
    public function setExpire($userId, $key, $time);

    //关闭连接
    public function close();
}
