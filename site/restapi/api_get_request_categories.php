<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once 'sql.php';
include_once 'request_cat.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$request_cat = new Request_cat($db);
 
// query products
$stmt = $request_cat->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num > 0){
 
    // products array
    $request_cat_arr=array();
    $request_cat_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $request_cat_item=array(
            "id" => $id,
            "name" => $name
        );
 
        array_push($request_cat_arr["records"], $request_cat_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($request_cat_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No request categories found.")
    );
}
?>