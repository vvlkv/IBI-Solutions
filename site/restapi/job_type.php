<?php
class Job_type{
 
    // database connection and table name
    private $conn;
    private $table_name = "job_types";
 
    // object properties
    public $id;
    public $name;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read job_types
function read(){
 
    // select all query
    $query = "SELECT u.* FROM " . $this->table_name . " u";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
}

