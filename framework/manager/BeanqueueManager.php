<?php
namespace framework\manager;

use framework\config\BeanqueueConfiguration;

require(ROOT_PATH . '/lib/pheanstalk/pheanstalk_init.php');

/**
 * Beanqueue管理工具，用于管理Beanqueue对象的工具。
 *
 * @author zivn
 * @package framework\manager
 */
class BeanqueueManager
{
    /**
     * Beanqueue配置
     *
     * @var <BeanqueueConfiguration>array
     */
    private static $configs;
    private static $bakconfigs;
    /**
     * Beanqueue实例
     *
     * @var \Beanqueue
     */
    private static $instance;

    /**
     * 添加Beanqueue配置
     *
     * @param BeanqueueConfiguration $config
     */
    public static function addConfigration($config)
    {
        if (isset($config['now']) && \is_array($config['now'])) {
            self::$configs = $config['now'];
        }
        if (isset($config['bak']) && \is_array($config['bak'])) {
            self::$bakconfigs = $config['bak'];
        }
    }

    public static function getAllConf($bak = false)
    {
        if ($bak) {
            return self::$bakconfigs;
        } else {
            return self::$configs;
        }
    }

    public static function getConf($id, $bak)
    {
        if (strlen($id) > 8) $id = substr($id, -8); // facebook的uid超过int范围
        $id = (int)$id;
        $mcid = $id % 100;
        if ($bak) {
            foreach (self::$bakconfigs as $k => $v) {
                if ($mcid < $v['rate']) {
                    return $v;
                }
            }
        } else {
            foreach (self::$configs as $k => $v) {
                if ($mcid < $v['rate']) {
                    return $v;
                }
            }
        }
        return $v;
    }

    public function getInstance($id, $bak = false)
    {
        $conf = self::getConf($id, $bak);
        return self::_getMc($conf);
    }

    /**
     * 获取Beanqueue实例
     *
     * @return \Beanqueue
     */
    public static function _getMc($conf)
    {
        $host = $conf['host'] . '_' . $conf['port'];
        if (isset(self::$instance[$host])) {
            if (!self::$instance[$host]['enable']) return false;
            if (\is_object(self::$instance[$host]['mc'])) return self::$instance[$host]['mc'];
        }

        self::$instance[$host]['enable'] = false;
        if ($conf['enable']) {
            try {
                self::$instance[$host]['mc'] = new \Pheanstalk($conf['host'], $conf['port']);
                self::$instance[$host]['mc']->useTube(PROJECT_NAME . '_' . APP_API);
                self::$instance[$host]['enable'] = true;
            } catch (\Exception $e) {
                \common\Log::info('beanqueue_new_fail', array('msg' => $e->getMessage()));
            }
        }

        if (!self::$instance[$host]['enable']) return false;
        return self::$instance[$host]['mc'];
    }
}

