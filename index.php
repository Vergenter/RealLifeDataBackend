<?php
include __DIR__.'//PermissionGetter//GetPermissions.php';
include __DIR__.'//PermissionChecker//PermissionChecker.php';
include 'router.php';
require __DIR__.'//vendor//autoload.php';

function init($method,$request,$JWT){
  header('Content-type: application/json',true,http_response_code());
  http_response_code(
    CheckPermission($request,$method,GetPermission($JWT))?
    route($request,$method):
    401
  );
  //header('Content-type: application/json',true,http_response_code());
}

init(
  isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:"",
  isset($_SERVER['PATH_INFO'])?explode("/", substr($_SERVER['PATH_INFO'], 1)):"",
  isset($_SERVER['HTTP_JWT'])?$_SERVER['HTTP_JWT']:""
);
