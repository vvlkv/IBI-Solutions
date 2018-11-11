<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
	public $vk_id;
    public $name;
    public $lastname;
    public $post;
    public $category;
    public $birth;
	public $phone;
    public $reg_date;
	public $u_category;
	//new
	public $timetable;
	public $status;
	public $email;
	public $work_phone;
	public $self_phone;
	public $area;
	public $password;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read users
function read(){
 
    // select all query
    $query = "SELECT u.*, c.name as u_category
                FROM " . $this->table_name . " u
           LEFT JOIN user_categories c
                  ON u.category = c.id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// create user
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
              SET name=:name, lastname=:lastname, category=:category, vk_id=:vk_id, post=:post, 
			      birth=:birth, work_phone=:work_phone, self_phone=:self_phone, reg_date=sysdate(),
				  area=:area, timetable=:timetable, email=:email, status=:status, password=:password";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->category=htmlspecialchars(strip_tags($this->category));
    $this->vk_id=htmlspecialchars(strip_tags($this->vk_id));
    $this->post=htmlspecialchars(strip_tags($this->post));
	$this->birth=htmlspecialchars(strip_tags($this->birth));
	
	$this->work_phone=htmlspecialchars(strip_tags($this->work_phone));
	$this->self_phone=htmlspecialchars(strip_tags($this->self_phone));
	$this->area=htmlspecialchars(strip_tags($this->area));
	$this->timetable=htmlspecialchars(strip_tags($this->timetable));
    $this->email=htmlspecialchars(strip_tags($this->email));
	$this->password=htmlspecialchars(strip_tags($this->password));
 
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":category", $this->category);
    $stmt->bindParam(":vk_id", $this->vk_id);
    $stmt->bindParam(":post", $this->post);
	$stmt->bindParam(":birth", $this->birth);
	$stmt->bindParam(":work_phone", $this->work_phone);
	$stmt->bindParam(":self_phone", $this->self_phone);
	$stmt->bindParam(":area", $this->area);
	$stmt->bindParam(":timetable", $this->timetable);
	$stmt->bindParam(":email", $this->email);
	$stmt->bindParam(":password", $this->password);
	
	
	$def_status = "WRK";
	$stmt->bindParam(":status", $def_status);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// read one request by id
function readCat(){
 
    // query to read single record
	// select all query
    $query = "SELECT u.category
                FROM " . $this->table_name . " u
               WHERE u.vk_id = ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->vk_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->category = $row['category'];
}

}

