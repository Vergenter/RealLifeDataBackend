<?php
require_once __DIR__.'//..//Permission//Permission.php';

function CheckPermission($path,$method,$Permissions){

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
