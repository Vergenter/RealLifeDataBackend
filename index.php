<?php
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));


switch ($method) {
  case 'PUT':
    do_something_with($request);  
    break;
  case 'POST':
    do_something_with($request);  
    break;
  case 'GET':
    die(join(" > ",$request));
    do_something_with($request);  
    break;
  default:
    handle_error($request);  
    break;
}