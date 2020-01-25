<?php
require_once __DIR__.'//..//..//Module.php';
require_once __DIR__.'//..//..//..//Repository//AccountRepository.php';
class Username implements IModule{

    private $Name;
    public function __construct($name){
        $this->Name=$name;
    }

    public function getChild($name){
        return [];
    }

    public function callMethod($name) :int{
        switch($name){
            case 'HEAD':
                return $this->headMethod();
            default:
                return 405;
        }
    }
    private function headMethod(){
        return (new AccountRepository())->AccountExist($this->Name)?
        200:
        404;
  
    }

}