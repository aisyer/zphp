zphp
====

a php framework,  专用于社交游戏 && 网页游戏的服务器端开发框架

要求：php5.3+

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
    php webroot/index.php Chat.start
    
    客户端： telnet host ip （host ,ip 在 inf/default/define.php 里设置 ）
    
php版key=>value数据库Demo (基于memcache协议):
=====================
    
    cd 程序目录
    php webroot/index.php Memcache.start
    
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
