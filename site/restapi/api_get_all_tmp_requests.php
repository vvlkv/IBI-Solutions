<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once 'sql.php';
include_once 'tmp_request.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tmp_request = new tmp_Request($db);
 
// query requests
$stmt = $tmp_request->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num > 0){
 
    //requests array
    $tmp_requests_arr=array();
    $tmp_requests_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $tmp_request_item=array(
            "id" => $id,
            "remark" => $remark,
            "creator_vk_id" => $creator_vk_id,
            "create_date" => $create_date,
			"photo_url" => $photo_url,
			"location" => $area_name
        );
 
        array_push($tmp_requests_arr["records"], $tmp_request_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tmp_requests data in json format
    echo json_encode($tmp_requests_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tmp_requests found
    echo json_encode(
        array("message" => "No tmp_requests found.")
    );
}
?>