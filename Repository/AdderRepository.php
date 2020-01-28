<?php

require_once "Repository.php";

class AdderRepository extends Repository {

    public function AddObject(string $name,string $description,Int $locationId)  {
        $stmt = $this->database->connect()->prepare('
        call createObject(:username,:description,:locationId)
        ');
        $stmt->bindParam(':username', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':locationId', $locationId, PDO::PARAM_STR);
        try{
            $stmt->execute();
        return 0;
        } catch(PDOException $ex){
            return $ex->getCode();
        }
    }
   
}