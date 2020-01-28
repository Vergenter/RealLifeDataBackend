<?php
include __DIR__.'//PermissionGetter//GetPermissions.php';
include __DIR__.'//PermissionChecker//PermissionChecker.php';
include 'router.php';
require __DIR__.'//vendor//autoload.php';

function init($method,$request,$JWT){
  header('Content-type: application/json');
  header('Access-Control-Allow-Origin: http://localhost:8080');
  if($method=="OPTIONS"){
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 60');
    header('Access-Control-Allow-Headers: username,password,Content-Type,JWT');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
  } else {
    mainLogic($method,$request,$JWT);
  }
}
function mainLogic($method,$request,$JWT){
  http_response_code(
    CheckPermission($request,$method,GetPermission($JWT))?
    route($request,$method):
    401
  );
}
init(
  isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:"",
  isset($_SERVER['PATH_INFO'])?explode("/", substr($_SERVER['PATH_INFO'], 1)):"",
  isset($_SERVER['HTTP_JWT'])?$_SERVER['HTTP_JWT']:""
);
