<?php
require_once __DIR__.'//..//Permission//DefaultPermission.php';

function GetPermission($jwt){
    if(empty($jwt)){
        return GetDefaultPermission();
    }
    die("stop with this JWT");
}