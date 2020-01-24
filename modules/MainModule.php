<?php
require_once 'Module.php';
require_once __DIR__.'//Token//Token.php';
require_once __DIR__.'//Account//Account.php';

class MainModule implements IModule{
    public function getChild($name){
        switch($name){
            case 'Account':
                return [new Account()];
            case 'Token':
                return [new Token()];
            default:
                return [];
        }
    }
    public function callMethod($name){
    }
}