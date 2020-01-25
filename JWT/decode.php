<?php
require_once 'config.php';
use \Firebase\JWT\JWT;

function decodeToken($JWT){
    return (array)JWT::decode($JWT, Config::SECRET, array('HS256'));
}