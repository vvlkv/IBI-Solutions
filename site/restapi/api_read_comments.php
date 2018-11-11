<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once 'sql.php';
include_once 'comment.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare request object
$comment = new Comment($db);
 
// set ID property of request to read comments
$comment->request = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of request to be edited
$stmt = $comment->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
// check if more than 0 record found
if($num > 0){
 
    //comments array
    $comments_arr=array();
    $comments_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $comment_item=array(
            "id" => $id,
            "remark" => $remark,
            "creator" => $creator_name,
            "create_date" => $create_date,
			"location" => $area_name,
			"request" => $request,
			"type" => $type
        );
 
        array_push($comments_arr["records"], $comment_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show comments data in json format
    echo json_encode($comments_arr, JSON_UNESCAPED_UNICODE);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no comments found
    echo json_encode(
        array("message" => "No comments found.")
    );
}

?>