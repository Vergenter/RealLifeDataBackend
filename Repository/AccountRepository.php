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
}