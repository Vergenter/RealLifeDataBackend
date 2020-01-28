<?php

require_once "Repository.php";

class AccountRepository extends Repository {

    public function AccountExist(string $name)  {
        $stmt = $this->database->connect()->prepare('
            SELECT 1 FROM account WHERE account_name = :name
        ');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return !!$res;
    }
    public function CreateNewAccount(string $username,string $hash,string $date)  {
        $stmt = $this->database->connect()->prepare('
        call createUserAccount(:username,:hash,:date)
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        try{
            $stmt->execute();
        return 0;
        } catch(PDOException $ex){
            return $ex->getCode();
        }
    }
}