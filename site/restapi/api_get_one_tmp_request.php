<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once 'sql.php';
include_once 'tmp_request.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare request object
$tmp_request = new tmp_Request($db);
 
// set ID property of record to read
$tmp_request->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of request to be edited
$tmp_request->readOne();
 
if($tmp_request->remark!=null){
    // create array
    $tmp_request_arr = array(
        "id" =>  $tmp_request->id,
        "remark" => $tmp_request->remark,
        "creator_vk_id" => $tmp_request->creator_vk_id,
		"create_date" => $tmp_request->create_date,
		"location" => $tmp_request->area_name,
		"photo_url" => $tmp_request->photo_url
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($tmp_request_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user request does not exist
    echo json_encode(array("message" => "tmp_Request does not exist."));
}
?>