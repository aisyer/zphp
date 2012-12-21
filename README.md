zphp
====

a php framework

专用于社交游戏 && 网页游戏的服务器端开发

一个典型的目录结构
classes
    -- ctrl  //ctrl目录
         IndexCtrl.php
    -- framework //框架目录
    
    -- inf        //配置目录
      -- default  //默认配置目录
          define.php
          
    -- webroot //网站根目录
         index.php
         

index.php代码示例：
<?php
use common\Utils;
use framework\core\Context;
use framework\dispatcher\HTTPRequestDispatcher;
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
