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
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->tmp_id) &&
    !empty($data->remark) &&
    !empty($data->creator) &&
    !empty($data->job_type) &&
    !empty($data->category) 
){
	$tmp_request->id = $data->tmp_id;
    // set user property values
    $tmp_request->remark = $data->remark;
    $tmp_request->creator = $data->creator;
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
    if($tmp_request->success_moderate()){
 
        // set response code - 201 created
        http_response_code(201);
		
		$tmp_request->drop();
		
        // tell the user
        echo json_encode(array("message" => "tmp_Request was success moderated."));
    }
 
    // if unable to create the request, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to moderate request."));
    }
}
 
// tell the request data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to moderate request. Data is incomplete."));
}
?>