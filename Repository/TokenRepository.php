<?php

require_once "Repository.php";

class TokenRepository extends Repository {

    public function login(string $username)  {
        
        $stmt = $this->database->connect()->prepare('
            SELECT account_id,account_name,role_id,hash,entry_id FROM account WHERE account_name = :name
        ');
        $stmt->bindParam(':name', $username, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
}