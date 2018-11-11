<?php
class Comment{
 
    // database connection and table name
    private $conn;
    private $table_name = "comments";
 
    // object properties
    public $id;
	public $create_date;
	public $creator;
    public $creator_name;
    public $request;
    public $type;
	public $remark;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read comments
function read(){
  
    // select all query
    $query = "SELECT c.*, concat(u.name, ' ', u.lastname) as creator_name
                FROM " . $this->table_name . " c,
                     users u
               WHERE c.creator = u.id 
                 AND c.request = ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->request);
  
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// create comment
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
              SET create_date=sysdate(), creator=:creator, request=:request, 
			      type=:type, remark=:remark";

    // prepare query
    $stmt = $this->conn->prepare($query);
 
    $def_type = "PUB";
 
    // sanitize
    $this->creator=htmlspecialchars(strip_tags($this->creator));
    $this->request=htmlspecialchars(strip_tags($this->request));
    $this->remark=htmlspecialchars(strip_tags($this->remark));
 
    // bind values
    $stmt->bindParam(":creator", $this->creator);
    $stmt->bindParam(":remark", $this->remark);
	$stmt->bindParam(":request", $this->request);
	$stmt->bindParam(":type", $def_type);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

}

