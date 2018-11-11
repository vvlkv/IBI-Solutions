<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once 'sql.php';
include_once 'request.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare request object
$request = new Request($db);
 
// set ID property of record to read
$request->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of request to be edited
$request->readOne();
 
if($request->remark!=null){
    // create array
    $request_arr = array(
        "id" =>  $request->id,
        "remark" => $request->remark,
        "creator" => $request->creator_name,
        "executer" => $request->executer_name,
        "category" => $request->rc_category,
        "state" => $request->req_state,
        "job_type" => $request->job,
		"hours" => $request->hours,
		"create_date" => $request->create_date,
		"location" => $request->area_name,
		"photo_url" => $request->photo_url
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($request_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user request does not exist
    echo json_encode(array("message" => "Request does not exist."));
}
?>