<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once 'sql.php';
include_once 'request.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare request object
$request = new Request($db);
 
// get id of request to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of request to be edited
$request->id = $data->id;
 
// set request property values
$request->executer = $data->executer;

 
// update the request
if($request->assign()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Request was assigned."));
}
 
// if unable to update the request, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to assign request."));
}
?>