<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once 'sql.php';
include_once 'exhibit_class.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$exhibit_cls = new Exhibit_class($db);
 
// query comment types
$stmt = $exhibit_cls->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num > 0){
 
    // comment types array
    $exhibit_cls_arr=array();
    $exhibit_cls_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $exhibit_cls_item=array(
            "id" => $id,
            "name" => $name
        );
 
        array_push($exhibit_cls_arr["records"], $exhibit_cls_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($exhibit_cls_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no area found
    echo json_encode(
        array("message" => "No exhibit classes found.")
    );
}
?>