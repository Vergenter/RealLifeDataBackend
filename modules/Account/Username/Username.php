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

    public function callMethod($name){
        switch($name){
            case 'HEAD':
                $this->headMethod();
                break;
            default:
                break;
        }
    }
    private function headMethod(){
        http_response_code((new AccountRepository())->AccountExist($this->Name)?200:404);
    }

}