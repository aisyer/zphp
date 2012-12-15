<?php

namespace framework\helper\cache;

/**
 * 控制器接口，控制器直接接收处理来自用户的请求，并且将处理结果交给View进行反馈给用户
 * @author xodger@gmail.com
 * @package framework\core
 */
interface ICacheHelper {

    function enable();

    function add($key, $value);

    function set($key, $value);

    function get($key);

    function delete($key);

    function increment($key, $step = 1);

    function decrement($key, $step = 1);
}