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
include_once 'request.php';
 
$database = new Database();
$db = $database->getConnection();
 
$request = new Request($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->remark) &&
    !empty($data->creator) &&
    !empty($data->job_type) &&
    !empty($data->category) 
){
 
    // set user property values
    $request->remark = $data->remark;
    $request->creator = $data->creator;
    $request->job_type = $data->job_type;
    $request->category = $data->category;

	if (!empty($data->location)) {
		$request->location = $data->location;
	} else {
		$request->location = "-1";
	}
	
	if (!empty($data->photo_url)){
	   $request->photo_url = $data->photo_url;
	} else {
	   $request->photo_url = "None";
	}
 
    // create the request
    if($request->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Request was created."));
    }
 
    // if unable to create the request, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create request."));
    }
}
 
// tell the request data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create request. Data is incomplete."));
}
?>