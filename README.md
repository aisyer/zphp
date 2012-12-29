zphp
====

@author: shenzhe (泽泽，半桶水)

@email: shenzhe163@gmail.com

a php framework,  专用于社交游戏 && 网页游戏的服务器端开发框架

zphp是一个极轻的框架，核心只提供类自动载入，路由功能，跟据游戏的特性，提供：存储(ttserver, redis, redis-storage)，cache(apc, memcache, redis, xcache), db(mysql)，队列(beanstalk, redis)，socket功能，你可能会发现存储居然没有mysql,这就是游戏,特别是社交游戏的特性：高并发，读写几乎都是并存的，没有明显冷数据，mysql不太适合这个场景

要求：php5.3+

更新
===================

2012-12-29: 更换socket层为：react, 独立于框架，类node语法，使socket使用更稳定和方便。
2012-12-29: 增加daemon支持（命令行后加 -d 即可），可以把服务变成一个daemon, 可接收进程控制信号，进行服务关闭，重启，重载等 

socket需要libevent扩展 :
========================

地址：https://github.com/shenzhe/php-libevent

    
特别支持redis-storage :
=====================

redis-stroage地址: https://github.com/qiye/redis-storage

增强版phpredis扩展：https://github.com/shenzhe/phpredis

     
聊天室demo:
=============
    
    cd 程序目录
    php webroot/index.php Chat.new -d (以daemon方式启动)
    
    客户端： telnet host ip （host ,ip 在 inf/default/define.php 里设置 ）

    php webroot/index.php Chat.stop (关闭服务)
    
php版key=>value数据库Demo (基于memcache协议):
=====================
    
    cd 程序目录
    php webroot/index.php Memcache.new
    
    客户端： 可以像操作memcache一样操作，目前支持的命令（get ,set delete）



一个典型的框架目录结构
==================

    classes
        -- ctrl  //ctrl目录
            IndexCtrl.php
        -- framework //框架目录
    
    inf        //配置目录
        --default  //默认配置目录
            define.php
          
    webroot //网站根目录
            index.php
         

index.php代码示例：

    <?php
    use common\Utils;
    use framework\core\Context;
    use framework\dispatcher\HTTPRequestDispatcher;
    $rootPath = realpath('..');
    require ($rootPath . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . "framework" . DIRECTORY_SEPARATOR . "setup.php");
    Context::setRootPath($rootPath);
    $infPath = Context::getRootPath() . DIRECTORY_SEPARATOR . 'inf' . DIRECTORY_SEPARATOR . 'default';
    Context::setInfoPath($infPath);
    Context::initialize();  //加载inf相关目录下所有文件
    new HTTPRequestDispatcher()->dispatch();

IndexCtrl.php代码示例：

    <?php
    namespace ctrl;
    class IndexCtrl {
        public function index() {
            echo 'hello world';
        }
    }

输入 http://host/?act=Index.index 访问 
