<?php
require_once __DIR__.'//..//Permission//DefaultPermission.php';
require_once __DIR__.'//..//Permission//NoPermission.php';
require_once __DIR__.'//..//Permission//UserPermission.php';
require_once __DIR__.'//..//Permission//SpecialWords.php';

require_once __DIR__.'//..//JWT//decode.php';

function GetPermission($jwt){
    if(empty($jwt)){
        return GetDefaultPermission();
    }
    try{
        return getPermissionFromToken($jwtPayload=decodeToken($jwt));
    } catch (RuntimeException $ex){
        return GetNoPermission();
    }

}
function getPermissionFromToken($jwtPayload){
    switch( $jwtPayload['role']){
        //'userID'
        case 1:
        return GetUserPermission(Words::ANY);//admin has permission for every user
        case 2:
        return GetUserPermission($jwtPayload['role']);
        default: 
        return GetNoPermission();
    }
}