<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once 'sql.php';
include_once 'tmp_request.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tmp_request object
$tmp_request = new tmp_Request($db);
 
// get product id
$data = json_decode(file_get_contents("php://input"));
 
// set tmp_request id to be deleted
$tmp_request->id = $data->id;
 
// delete the tmp_request
if($tmp_request->drop()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "tmp_Request was deleted."));
}
 
// if unable to delete the tmp_request
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete tmp_request."));
}
?>