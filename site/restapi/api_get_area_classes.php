<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once 'sql.php';
include_once 'area_class.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$area_cls = new Area_class($db);
 
// query comment types
$stmt = $area_cls->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num > 0){
 
    // comment types array
    $area_cls_arr=array();
    $area_cls_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $area_cls_item=array(
            "id" => $id,
            "name" => $name
        );
 
        array_push($area_cls_arr["records"], $area_cls_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($area_cls_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no area found
    echo json_encode(
        array("message" => "No area classes found.")
    );
}
?>