<?php
require_once __DIR__.'//modules//MainModule.php';

function route($path,$method){

    $module=new MainModule();
    foreach ($path as $part) {
        $tmp=$module->getChild($part);
        if(empty($tmp)){
            return false;
        }
        $module=reset($tmp);
    }
    return $module->callMethod($method);
}