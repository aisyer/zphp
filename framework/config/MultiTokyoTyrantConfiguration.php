<?php
namespace framework\config;

/**
 * 联合TokyoTyrant配置信息
 *
 * @author zivn
 * @package framework\config
 */
class MultiTokyoTyrantConfiguration
{
    /**
     * 主TokyoTyrant服务器dsn链接
     *
     * @var string
     */
    public $masterUri;
    /**
     * 从TokyoTyrant服务器dsn链接
     *
     * @var string
     */
    public $slaveUri;

    /**
     * 构造函数
     *
     * @param string $uri
     */
    public function __construct($masterUri, $slaveUri)
    {
        $this->masterUri = $masterUri;
        $this->slaveUri = $slaveUri;
    }


    public function tt2mem($rate)
    {
        $mast = \str_replace("tcp://", "", $this->masterUri);
        $mast = \explode(":", $mast);
        $slave = \str_replace("tcp://", "", $this->slaveUri);
        $slave = \explode(":", $slave);
        return array( //硬盘ttserver
            'rate' => $rate,
            'enable' => true,
            'host' => $mast[0],
            'port' => trim($mast[1], "/"),
            'mem' => array( //内存ttserver(当前用户数据主要存取处)
                array('enable' => true, 'host' => $slave[0], 'port' => trim($slave[1], "/")),
            ),
        );
    }
}