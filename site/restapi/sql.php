<?php
class Database{
 
    // specify your own database credentials
    private $host = "ouchsu00.mysql";
    private $db_name = "ouchsu00_vkapi";
    private $username = "ouchsu00_vkapi";
    private $password = "Vkapi123";
    public $conn;
 
    // get the database connection
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