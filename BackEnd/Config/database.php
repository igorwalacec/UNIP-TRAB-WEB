<?php
class Database{
     
    private $host = "remotemysql.com";
    private $db_name = "CNabqQ94RO";
    private $username = "CNabqQ94RO";
    private $password = "juPGiWfasfabggR";
    public $conn;
     
    public function getConnection(){        
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>