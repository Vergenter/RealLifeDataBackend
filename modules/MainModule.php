<?php
require_once 'Module.php';
require_once __DIR__.'//Token//Token.php';
require_once __DIR__.'//Account//Account.php';
require_once __DIR__.'//UserId//UserId.php';
class MainModule implements IModule{
    public function getChild($name){
        switch($name){
            case 'Account':
                return [new Account()];
            case 'Token':
                return [new Token()];
            default:
                return [new UserId($name)];
        }
    }
    public function callMethod($name) :int{
        return 405;
    }
}