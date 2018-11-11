<?php
class Area{
 
    // database connection and table name
    private $conn;
    private $table_name = "areas";
 
    // object properties
    public $id;
	public $name;
	public $type;
    public $dep;
    public $class;
    public $floor;
	 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
// read all areas for guests
function read_for_guest(){
  
    // select all query
    $query = "SELECT a.*
                FROM " . $this->table_name . " a
               WHERE a.type = 'OPN' 
              ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// read all areas
function read(){
  
    // select all query
    $query = "SELECT a.*
                FROM " . $this->table_name . " a
              ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


}

