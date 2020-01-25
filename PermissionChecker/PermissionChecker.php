<?php
require_once __DIR__.'//..//Permission//Permission.php';

function CheckPermission($path,$method,$Permissions){

    if(empty($path)){
        return false;
    }
    $subpermission=$Permissions;
    foreach ($path as $part) {
        $tmp=$subpermission->getPermission($part);
        if(empty($tmp)){
            return false;
        }
        $subpermission=reset($tmp);
    }
    return $subpermission->hasMethod($method);
}
