<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once 'sql.php';
include_once 'request.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$request = new Request($db);
 
// query requests
$stmt = $request->read_help();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num > 0){
 
    //requests array
    $requests_arr=array();
    $requests_arr["records"]=array();
 
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
            "hours" => $hours,
			"photo_url" => $photo_url,
			"location" => $area_name
        );
 
        array_push($requests_arr["records"], $request_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show requests data in json format
    echo json_encode($requests_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no requests found
    echo json_encode(
        array("message" => "No requests found.")
    );
}
?>