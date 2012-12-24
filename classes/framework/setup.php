<?php

use framework\core\Context;
use framework\util\Formater;
use framework\view\JSONView;

require(__DIR__ . DIRECTORY_SEPARATOR . "core/Context.php");

set_exception_handler("exception_handler");

function __autoload($class) {
    $baseClasspath = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $classpath = Context::getClassesRoot() . DIRECTORY_SEPARATOR . $baseClasspath;
    require($classpath);
}

function exception_handler($exception) {
    $exceptionView = new JSONView(Formater::formatException($exception));
    $exceptionView->display();
}
