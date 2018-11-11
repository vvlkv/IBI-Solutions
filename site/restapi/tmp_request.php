<?php
class tmp_Request{
 

    // database connection and table name
    private $conn;
    private $table_name = "tmp_requests";
 
    // object properties
    public $id;
	public $create_date;
	public $creator_vk_id;
	public $remark;
	public $location;
	public $area_name;
	public $photo_url;
	public $creator;
	public $job_type;
	public $category;
	public $count;
		
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read all requests
function read(){
  
    // select all query
    $query = "SELECT tr.*, a.name as area_name
                FROM " . $this->table_name . " tr,
					 areas a
               WHERE coalesce(tr.location, '-1') = a.id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// create request
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
              SET create_date=sysdate(), creator_vk_id=:creator_vk_id, remark=:remark, 
			      location=:location, photo_url=:photo_url";

    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->creator_vk_id=htmlspecialchars(strip_tags($this->creator_vk_id));
    $this->remark=htmlspecialchars(strip_tags($this->remark));
	$this->location=htmlspecialchars(strip_tags($this->location));
	$this->photo_url=htmlspecialchars(strip_tags($this->photo_url));
 
    // bind values
    $stmt->bindParam(":creator_vk_id", $this->creator_vk_id);
    $stmt->bindParam(":remark", $this->remark);
	$stmt->bindParam(":location", $this->location);
	$stmt->bindParam(":photo_url", $this->photo_url, PDO::PARAM_LOB);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// read one request by id
function readOne(){
 
    // query to read single record
	// select all query
    $query = "SELECT tr.*, a.name as area_name
                FROM " . $this->table_name . " tr,
					 areas a
               WHERE coalesce(tr.location, '-1') = a.id
				 AND tr.id = ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->id = $row['id'];
    $this->create_date = $row['create_date'];
    $this->creator_vk_id = $row['creator_vk_id'];
	$this->remark = $row['remark'];
	$this->area_name = $row['area_name'];
	$this->photo_url = $row['photo_url'];
}

// assign the request
function success_moderate(){

    // query to insert record
    $query = "INSERT INTO requests
                      SET create_date=sysdate(), creator=:creator, category=:category, job_type=:job_type, 
			              state=:state, remark=:remark, location=:location, photo_url=:photo_url";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    $def_state = "NEW";
 
    // sanitize
    $this->creator=htmlspecialchars(strip_tags($this->creator));
    $this->job_type=htmlspecialchars(strip_tags($this->job_type));
    $this->category=htmlspecialchars(strip_tags($this->category));
    $this->remark=htmlspecialchars(strip_tags($this->remark));
	$this->location=htmlspecialchars(strip_tags($this->location));
	$this->photo_url=htmlspecialchars(strip_tags($this->photo_url));
 
    // bind values
    $stmt->bindParam(":creator", $this->creator);
    $stmt->bindParam(":job_type", $this->job_type);
    $stmt->bindParam(":category", $this->category);
    $stmt->bindParam(":remark", $this->remark);
	$stmt->bindParam(":location", $this->location);
	$stmt->bindParam(":photo_url", $this->photo_url);
	$stmt->bindParam(":state", $def_state);

    // execute query
    if($stmt->execute()){
        return true;
    }
    return false;
}

// delete the tmp_request
function drop(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;    
}

// count requests in help
function count_tmp(){
  
    // select all query
    $query = "SELECT count(*) as count_tmp
                FROM " . $this->table_name . "                 
               ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


}

