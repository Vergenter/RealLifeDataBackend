<?php

require_once "config.php";

class Database {
    private $username=DB::USERNAME;
    private $password=DB::PASSWORD;
    private $host=DB::HOST;
    private $database=DB::DATABASE;

    public function connect()
    {
        try {
            $conn = new PDO(
                "pgsql:host=$this->host;dbname=$this->database", 
                $this->username,
                $this->password
            );
           
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}