<?php
use framework\core\Context;
use framework\dispatcher\HTTPRequestDispatcher;
$rootPath = realpath('..');
require ($rootPath . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . "framework" . DIRECTORY_SEPARATOR . "setup.php");
Context::setRootPath($rootPath);
$infPath = Context::getRootPath() . DIRECTORY_SEPARATOR . 'inf' . DIRECTORY_SEPARATOR . 'default';
Context::setInfoPath($infPath);
Context::initialize();  //加载inf相关目录下所有文件
new HTTPRequestDispatcher()->dispatch();