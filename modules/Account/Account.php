<?php
require_once __DIR__.'//..//Module.php';
require_once __DIR__.'//Username//Username.php';
require_once __DIR__.'//..//..//POST//getPostData.php';
require_once __DIR__.'//..//..//Repository//AccountRepository.php';
require_once __DIR__.'//..//..//helper//simpleValidateString.php';
class Account implements IModule{
    public function getChild($name){
        return [new Username($name)];
    }
    public function callMethod($name) :int{
        switch($name){
            case 'POST':
                return $this->register(getPostData());
            default:
                return 405;
        }
    }
    private function register($data){
        if(!$this->validateRegistration($data)){
            return 400;
        }
        $repository = new AccountRepository();
        switch($repository->CreateNewAccount(
            $data["name"],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $data["date"]
        )){
            case 0: // ok
                return 201;
            case 23505: // email taken
                return 403;
            default:
                return 400;
        }
    }
    private function validateRegistration($data){
        return isSetAndHasValue($data,"name") &&
            isSetAndHasValue($data,"password") &&
            isSetAndHasValue($data,"date");
    }

}