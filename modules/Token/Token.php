<?php
require_once __DIR__.'//..//Module.php';
require_once __DIR__.'//..//..//helper//simpleValidateString.php';
require_once __DIR__.'//..//..//Repository//TokenRepository.php';
require_once __DIR__.'//..//..//JWT//encode.php';
class Token implements IModule{
    public function getChild($name){
        return [];
    }
    public function callMethod($name):int {
        switch($name){
            case 'GET':
                return $this->getMethod($_SERVER);
            default:
                return 405;
        }
    }
    private function getMethod($data){
        if(!$this->validateLogin($data)){
            return 400;
        }
        $user=(new TokenRepository())->login(
            $data["HTTP_USERNAME"]
        );
        if(!password_verify ( $data["HTTP_PASSWORD"] , $user['hash'] )){
            return 400;
        }
        echo JSON_encode(createToken($user));
        return 200;
  
    }
    private function validateLogin($data){
        return  isSetAndHasValue($data,"HTTP_USERNAME") &&
            isSetAndHasValue($data,"HTTP_PASSWORD");
    }
}