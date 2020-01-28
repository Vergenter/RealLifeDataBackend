<?php
require_once __DIR__.'//..//..//Module.php';
require_once __DIR__.'//..//..//..//POST//getPostData.php';
require_once __DIR__.'//..//..//..//helper//simpleValidateString.php';
require_once __DIR__.'//..//..//..//Repository//AdderRepository.php';

class Adder implements IModule{

    private $UserId;
    public function __construct($userId){
        $this->UserId=$userId;
    }

    public function getChild($name){
        return [];
    }

    public function callMethod($name) :int{
        switch($name){
            case 'POST':
                return $this->postMethod(getPostData());
            default:
                return 405;
        }
    }
    private function postMethod($data){
        if(!$this->validateObject($data)){
            return 400;
        }
        $repository = new AdderRepository();
        switch($repository->AddObject(
            $data["Name"],
            isSetAndHasValue($data,"Description")?$data["Description"]:'',
            $data["LocationId"]
        )){
            case 0: // ok
                return 201;
            default:
                return 400;
        }
    }
    private function validateObject($data){
        return isSetAndHasValue($data,"TypeId") &&
            $data["TypeId"]==1&&        //must be object
            isSetAndHasValue($data,"Name") &&
            isSetAndHasValue($data,"LocationId") &&
            isSetAndHasValue($data,"Description");
    }

}