<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once 'sql.php';
include_once 'user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare request object
$user = new User($db);
 
// set ID property of record to read
$user->vk_id = isset($_GET['vk_id']) ? $_GET['vk_id'] : die();
 
// read the details of request to be edited
$user->readCat();
 
if($user->category!=null){
    // create array
    $user_arr = array(
		"category" => $user->category
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($user_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user request does not exist
    echo json_encode(array("message" => "User does not exist."));
}
?>