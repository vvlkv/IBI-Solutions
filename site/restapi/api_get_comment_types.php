<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once 'sql.php';
include_once 'comment_type.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$comment_tp = new Comment_type($db);
 
// query comment types
$stmt = $comment_tp->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num > 0){
 
    // comment types array
    $comment_tp_arr=array();
    $comment_tp_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $comment_tp_item=array(
            "id" => $id,
            "name" => $name
        );
 
        array_push($comment_tp_arr["records"], $comment_tp_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($comment_tp_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No comment types found.")
    );
}
?>