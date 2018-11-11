<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once 'sql.php';
// instantiate request object
include_once 'tmp_request.php';
 
$database = new Database();
$db = $database->getConnection();
 
$tmp_request = new tmp_Request($db);
 
 
 
$bytesToRead = 4096000;
$input = fread(STDIN, $bytesToRead ); // reads 4096K bytes from STDIN
// assuming it's json you accept:
$data = json_decode($input , true);
 
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->remark) &&
    !empty($data->creator_vk_id) 
){
 
    // set user property values
    $tmp_request->remark = $data->remark;
    $tmp_request->creator_vk_id = $data->creator_vk_id;
    $tmp_request->job_type = $data->job_type;
    $tmp_request->category = $data->category;

	if (!empty($data->location)) {
		$tmp_request->location = $data->location;
	} else {
		$tmp_request->location = "-1";
	}
	
	if (!empty($data->photo_url)){
	   $tmp_request->photo_url = $data->photo_url;
	} else {
	   $tmp_request->photo_url = "None";
	}
 
    // create the request
    if($tmp_request->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "tmp_Request was created."));
    }
 
    // if unable to create the request, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create tmp_request."));
    }
}
 
// tell the request data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create tmp_request. Data is incomplete."));
}
?>