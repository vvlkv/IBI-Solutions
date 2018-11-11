<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once 'sql.php';
// instantiate user object
include_once 'user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->lastname) &&
    !empty($data->vk_id) &&
    !empty($data->category) &&
	!empty($data->email) &&
	!empty($data->password) 
){
 
    // set user property values
    $user->name = $data->name;
    $user->lastname = $data->lastname;
    $user->vk_id = $data->vk_id;
    $user->category = $data->category;
	$user->post = $data->post;
	$user->birth = $data->birth;
	$user->work_phone = $data->work_phone;
	$user->self_phone = $data->self_phone;
	$user->area = $data->area;
	$user->timetable = $data->timetable;
	$user->email = $data->email;
	$user->password = $data->password;
		
	//$user->reg_date = date('Y-m-d H:i:s');
 
    // create the product
    if($user->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "User was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create user."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
}
?>