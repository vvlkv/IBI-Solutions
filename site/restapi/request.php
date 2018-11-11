<?php
class Request{
 
    // database connection and table name
    private $conn;
    private $table_name = "requests";
 
    // object properties
    public $id;
	public $create_date;
	public $creator;
    public $executer;
    public $creator_name;
    public $executer_name;
    public $category;
	public $rc_category;
    public $job_type;
	public $job;
    public $state;
	public $req_state;
	public $remark;
	public $location;
	public $area_name;
	public $photo_url;
	
	// счетчики для статистики (шапка сайта)
	public $count_free;
	public $count_in_work;
	public $count_in_help;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
// read all requests
function read(){
  
    // select all query
    $query = "SELECT r.*, rc.name as rc_category, concat(u.name, ' ', u.lastname) as executer_name, 
                     concat(uu.name, ' ', uu.lastname) as creator_name, rs.name as req_state, jt.name as job,
					 a.name as area_name
                FROM " . $this->table_name . " r,
                     request_categories rc,
                     users u,
                     users uu,
                     request_states rs,
                     job_types jt,
					 areas a
               WHERE r.creator = uu.id 
                 AND coalesce(r.executer, '-1') = u.id
                 AND r.category = rc.id
                 AND r.job_type = jt.id
                 AND r.state = rs.id
				 AND coalesce(r.location, '-1') = a.id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// read all advs
function read_adv(){
  
    // select all query
    $query = "SELECT r.*, rc.name as rc_category,  
                     concat(uu.name, ' ', uu.lastname) as creator_name					
                FROM " . $this->table_name . " r,
                     request_categories rc,
                     users uu
               WHERE r.creator = uu.id              
                 AND r.category = rc.id
				 AND r.category = 'ADV'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

function read_help(){
  
    // select all query
    $query = "SELECT r.*, rc.name as rc_category, concat(u.name, ' ', u.lastname) as executer_name, 
                     concat(uu.name, ' ', uu.lastname) as creator_name, rs.name as req_state, jt.name as job,
					 a.name as area_name
                FROM " . $this->table_name . " r,
                     request_categories rc,
                     users u,
                     users uu,
                     request_states rs,
                     job_types jt,
					 areas a
               WHERE r.creator = uu.id 
                 AND coalesce(r.executer, '-1') = u.id
                 AND r.category = rc.id
                 AND r.job_type = jt.id
                 AND r.state = rs.id
				 AND coalesce(r.location, '-1') = a.id
				 AND r.state = 'HLP'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

function read_work(){
  
    // select all query
    $query = "SELECT r.*, rc.name as rc_category, concat(u.name, ' ', u.lastname) as executer_name, 
                     concat(uu.name, ' ', uu.lastname) as creator_name, rs.name as req_state, jt.name as job,
					 a.name as area_name
                FROM " . $this->table_name . " r,
                     request_categories rc,
                     users u,
                     users uu,
                     request_states rs,
                     job_types jt,
					 areas a
               WHERE r.creator = uu.id 
                 AND coalesce(r.executer, '-1') = u.id
                 AND r.category = rc.id
                 AND r.job_type = jt.id
                 AND r.state = rs.id
				 AND coalesce(r.location, '-1') = a.id
				 AND r.state = 'WRK'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

function read_free(){
  
    // select all query
    $query = "SELECT r.*, rc.name as rc_category, concat(u.name, ' ', u.lastname) as executer_name, 
                     concat(uu.name, ' ', uu.lastname) as creator_name, rs.name as req_state, jt.name as job,
					 a.name as area_name
                FROM " . $this->table_name . " r,
                     request_categories rc,
                     users u,
                     users uu,
                     request_states rs,
                     job_types jt,
					 areas a
               WHERE r.creator = uu.id 
                 AND coalesce(r.executer, '-1') = u.id
                 AND r.category = rc.id
                 AND r.job_type = jt.id
                 AND r.state = rs.id
				 AND coalesce(r.location, '-1') = a.id
				 AND r.state = 'NEW'
				 AND r.category <> 'ADV'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

	// read self requests
function read_self(){
  
    // select all query
    $query = "SELECT r.*, rc.name as rc_category, concat(u.name, ' ', u.lastname) as executer_name, 
                     concat(uu.name, ' ', uu.lastname) as creator_name, rs.name as req_state, jt.name as job,
					 a.name as area_name
                FROM " . $this->table_name . " r,
                     request_categories rc,
                     users u,
                     users uu,
                     request_states rs,
                     job_types jt,
					 areas a
               WHERE r.creator = uu.id 
                 AND coalesce(r.executer, '-1') = u.id
                 AND r.category = rc.id
                 AND r.job_type = jt.id
                 AND r.state = rs.id
				 AND coalesce(r.location, '-1') = a.id
				 AND r.executer = ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->executer);
  
    // execute query
    $stmt->execute();
 
    return $stmt;
}


// create request
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
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
	$stmt->bindParam(":photo_url", $this->photo_url, PDO::PARAM_LOB);
	$stmt->bindParam(":state", $def_state);
 
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
    $query = "SELECT r.*, rc.name as rc_category, concat(u.name, ' ', u.lastname) as executer_name, 
                     concat(uu.name, ' ', uu.lastname) as creator_name, rs.name as req_state, jt.name as job,
					 a.name as area_name
                FROM " . $this->table_name . " r,
                     request_categories rc,
                     users u,
                     users uu,
                     request_states rs,
                     job_types jt,
					 areas a
               WHERE r.creator = uu.id 
                 AND coalesce(r.executer, '-1') = u.id
                 AND r.category = rc.id
                 AND r.job_type = jt.id
                 AND r.state = rs.id
				 AND coalesce(r.location, '-1') = a.id
				 AND r.id = ?";
 
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
    $this->creator_name = $row['creator_name'];
    $this->executer_name = $row['executer_name'];
    $this->rc_category = $row['rc_category'];
	$this->req_state = $row['req_state'];
	$this->job = $row['job'];
	$this->remark = $row['remark'];
	$this->area_name = $row['area_name'];
	$this->photo_url = $row['photo_url'];
	$this->hours = $row['hours'];	
}

// assign the request
function assign(){
 
    // assign query
    $query = "UPDATE
                " . $this->table_name . "
              SET
                executer = :executer,
                state = :state
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    $new_state = "SET";
 
    // sanitize
    $this->executer=htmlspecialchars(strip_tags($this->executer));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':executer', $this->executer);
	$stmt->bindParam(':state', $new_state);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
    return false;
}

// assign the request
function change_state(){
 
    // assign query
    $query = "UPDATE
                " . $this->table_name . "
              SET
                state = :state
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    $new_state = "SET";
 
    // sanitize
    $this->state=htmlspecialchars(strip_tags($this->state));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':state', $this->state);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
    return false;
}

// count free requests
function count_free(){
  
    // select all query
    $query = "SELECT count(*) as count_free
                FROM " . $this->table_name . " r                
               WHERE r.executer is null
			     AND category <> 'ADV'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// count requests in work
function count_in_work(){
  
    // select all query
    $query = "SELECT count(*) as count_in_work
                FROM " . $this->table_name . " r                
               WHERE r.state = 'WRK'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// count requests in help
function count_in_help(){
  
    // select all query
    $query = "SELECT count(*) as count_in_help
                FROM " . $this->table_name . " r                
               WHERE r.state = 'HLP'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}




}

