<?php
require_once __DIR__.'//..//Module.php';
require_once __DIR__.'//Adder//Adder.php';

class UserId implements IModule{

    private $Id;
    public function __construct($id){
        $this->Id=$id;
    }

    public function getChild($name){
        switch($name){
            case 'Adder':
                return [new Adder($this->Id)];
            default:
                return [];
        }
    }

    public function callMethod($name) :int{
        return 405;
    }
}