<?php // -*-coding:utf-8; mode:php-mode;-*-

namespace framework\dispatcher;

/**
 * 用于执行控制台脚本的请求转发器。
 * @author xodger@gmail.com
 * @package framework\dispatcher
 */
class ShellRequestDispatcher extends RequestDispatcherBase
{

    private $ctrlClassName;

    private $ctrlMethodName;

    public function __construct()
    {
        $this->defaultAction = 'Shell.main';
        if (isset($_SERVER['argv']) && isset($_SERVER['argv'][1])) {
            $act = $_SERVER['argv'][1];
        } else {
            $act = $this->defaultAction;
        }

        if (\preg_match('/^([a-z_]+)\.([a-z_]+)$/i', $act, $arr)) {
            $this->ctrlClassName = $arr[1] . 'Ctrl';
            $this->ctrlMethodName = $arr[2];
        }
    }

    public function getCtrlClassName()
    {
        return $this->ctrlClassName;
    }

    public function getCtrlMethodName()
    {
        return $this->ctrlMethodName;
    }
}