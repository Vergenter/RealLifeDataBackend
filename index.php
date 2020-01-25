<?php
include __DIR__.'//PermissionGetter//GetPermissions.php';
include __DIR__.'//PermissionChecker//PermissionChecker.php';
include 'router.php';
require __DIR__.'//vendor//autoload.php';

function setAndReturnResponseCode($code){
  http_response_code($code);
  echo http_response_code();
}

function init($method,$request,$JWT){
  if(!CheckPermission($request,$method,GetPermission($JWT))){
    setAndReturnResponseCode(401);
    return;
  }
  //route($request,$method);
  echo http_response_code();
}

init(
  isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:"",
  isset($_SERVER['PATH_INFO'])?explode("/", substr($_SERVER['PATH_INFO'], 1)):"",
  isset($_GET['JWT'])?$_GET['JWT']:""
);
