<?php
require_once 'SpecialWords.php';
function comparePermission($real,$permission){
    if($permission==Words::ANY){
        return true;
    }
    return $real==$permission;
}