<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shenzhe
 * Date: 12-8-11
 * Time: 下午10:38
 * To change this template use File | Settings | File Templates.
 */
namespace framework\socket;
class SScoket
{

    private static $serv = null;
    private static $client = array();

    public static function init($config)
    {
        self::$serv = \swoole_server_create($config['host'], $config['port'], 1);
        swoole_server_set(self::$serv, array(
            'timeout' => $config['timeout'],
            'poll_thread_num' => $config['poll_thread_num'],
            'writer_num' => $config['writer_num'],
            'worker_num' => $config['worker_num'],
            'backlog' => $config['backlog'],
        ));
    }

    public static function start()
    {
        \swoole_server_handler(self::$serv, 'onStart', '\\framework\\socket\\SScoket::my_onStart');
        \swoole_server_handler(self::$serv, 'onConnect', '\\framework\\socket\\SScoket::my_onConnect');
        \swoole_server_handler(self::$serv, 'onReceive', '\\framework\\socket\\SScoket::my_onReceive');
        \swoole_server_handler(self::$serv, 'onClose', '\\framework\\socket\\SScoket::my_onClose');
        \swoole_server_handler(self::$serv, 'onShutdown', '\\framework\\socket\\SScoket::my_onShutdown');

        \swoole_server_start(self::$serv);
    }

    public static function my_onStart($serv)
    {
        echo "Server：start\n";
    }

    public static function my_onShutdown($serv)
    {
        echo "Server：onShutdown(\n";
    }

    public static function my_onClose($serv, $fd, $from_id)
    {
        if (isset(self::$client[$fd])) {
            unset(self::$client[$fd]);
            echo "Client：Close. fd=$fd|from_id=$from_id\n";
        }
    }

    public static function my_onConnect($serv, $fd, $from_id)
    {
        self::$client[$fd] = 1;
    }

    public static function my_onReceive($serv, $fd, $from_id, $data)
    {

    }


    public static function sendTo($serv, $fd, $msg)
    {
        \swoole_server_send($serv, $fd, " Say: $data");
    }

    public static function sendAll($serv, $fd, $data)
    {
        if (empty($data)) {
        } else {
            echo "Client：Data. fd=$fd|from_id=$from_id|data=$data\n";
            global $client;
            foreach ($client as $_fd => $uname) {
                if ($_fd == $fd || empty($uname) || empty($data)) {
                    continue;
                }
                swoole_server_send($serv, $_fd, $client[$fd] . " 说: $data\n");
            }
        }
    }


}
