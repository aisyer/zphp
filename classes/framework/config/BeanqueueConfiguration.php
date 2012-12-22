<?php

namespace framework\config;

/**
 * 队列配置信息
 *
 * @author zivn
 * @package framework\config
 */
class BeanqueueConfiguration {

    const TTR = 120;

    /**
     * 主配置
     *
     * @var string
     */
    private $conf;

    /**
     * 备份配置
     *
     * @var int
     */
    private $bakconf;

    /**
     * 构造函数
     *
     * @param string $host
     * @param int $port
     */
    public function __construct($conf, $backconf) {
        $this->conf = $conf;
        $this->backconf = $backconf;
    }

}