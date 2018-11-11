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
 
// set ID property of request to read comments
$request->executer = isset($_GET['ex_id']) ? $_GET['ex_id'] : die();
 
// read the details of request to be edited
$stmt = $request->read_self();
$num = $stmt->rowCount();
 
// check if more than 0 record found
// check if more than 0 record found
if($num > 0){
 
    //comments array
    $request_arr=array();
    $request_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $request_item=array(
            "id" => $id,
            "remark" => $remark,
            "creator" => $creator_name,
			"executer" => $executer_name,
            "rc_category" => $rc_category,
			"req_state" => $req_state,
			"job_type" => $job,
            "create_date" => $create_date,
			"photo_url" => $photo_url,
			"location" => $area_name
        );
 
        array_push($request_arr["records"], $request_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show comments data in json format
    echo json_encode($request_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no comments found
    echo json_encode(
        array("message" => "No requests found.")
    );
}

?>