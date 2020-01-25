<?php
require_once __DIR__.'//modules//MainModule.php';

function route($path,$method){
    if(empty($path)){
        return 404;
    }
    $module=new MainModule();
    foreach ($path as $part) {
        $tmp=$module->getChild($part);
        if(empty($tmp)){
            return 404;
        }
        $module=reset($tmp);
    }
    return $module->callMethod($method);
}