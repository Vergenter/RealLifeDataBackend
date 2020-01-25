<?php
require_once __DIR__.'//..//Module.php';
require_once __DIR__.'//Username//Username.php';
require_once __DIR__.'//..//..//Repository//AccountRepository.php';
require_once __DIR__.'//..//..//helper//simpleValidateString.php';
class Account implements IModule{
    public function getChild($name){
        return [new Username($name)];
    }
    public function callMethod($name) :int{
        switch($name){
            case 'POST':
                return $this->register($_POST);
            default:
                return 405;
        }
    }
    private function register($data){
        if(!$this->validateRegistration($data)){
            return 400;
        }
        $repository = new AccountRepository();
        return $repository->CreateNewAccount(
            $data["name"],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $data["date"]
        ) ? 201 : 400;
    }
    private function validateRegistration($data){
        return isSetAndHasValue($data,"name") &&
            isSetAndHasValue($data,"password") &&
            isSetAndHasValue($data,"date");
    }

}