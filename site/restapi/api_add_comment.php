<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once 'sql.php';
// instantiate comment object
include_once 'comment.php';
 
$database = new Database();
$db = $database->getConnection();
 
$comment = new Comment($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->creator) &&
    !empty($data->request) &&
    !empty($data->remark)
){
 
    // set user property values
    $comment->creator = $data->creator;
    $comment->request = $data->request;
    $comment->remark = $data->remark;
 
    // add the comment
    if($comment->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Comment was added."));
    }
 
    // if unable to create the comment, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to add comment."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to add comment. Data is incomplete."));
}
?>