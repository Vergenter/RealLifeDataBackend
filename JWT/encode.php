<?php
require_once 'config.php';
use \Firebase\JWT\JWT;

function createToken($User){
    $payload = array(
        "iss" => Config::HOST,
        "iat" => time(),
        "nbf" => time()+Config::EXPIRATIONTIME,
        "jti" => time(),
        "userId" => $User['account_id'],
        "username" => $User['account_name'],
        "role" => $User['role_id'],
        "entry" => $User['entry_id']
    );
    return JWT::encode($payload, Config::SECRET);
}