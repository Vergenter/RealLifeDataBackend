<?php
require_once __DIR__.'//..//Module.php';
require_once __DIR__.'//Username//Username.php';

class Account implements IModule{
    public function getChild($name){
        return [new Username($name)];
    }
    public function callMethod($name){
        switch($name){
            case 'POST':
                $this->postMethod();
                break;
            default:
                break;
        }
    }
    private function postMethod(){

    }
}