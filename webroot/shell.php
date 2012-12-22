<?php
use common\Utils;
use framework\core\Context;
use framework\dispatcher\ShellRequestDispatcher;
define('ROOT_PATH', realpath(dirname(realpath(__FILE__)).'/../'));
include(ROOT_PATH."/classes/framework/setup.php");

Context::setRootPath(ROOT_PATH);
$infPath = Context::getRootPath() . DIRECTORY_SEPARATOR . 'inf' . DIRECTORY_SEPARATOR . "default";
Context::setInfoPath($infPath);
Context::initialize();  //加载inf相关目录下所有文件

$dispatcher = new ShellRequestDispatcher();
$dispatcher->dispatch();