<?php
require_once __DIR__.'//..//Module.php';

class Token implements IModule{
    public function getChild($name){
        return [];
    }
    public function callMethod($name){
        switch($name){
            case 'GET':
                $this->getMethod();
                break;
            default:
                break;
        }
    }
    private function getMethod(){
        echo "Token Get";
    }
}