<?php 
include("auth.php"); 

$user_id = $_SESSION['UID'];
$req_id = $_POST['req_id'];
$com_remark = $_POST['remark'];
$result = $db->query("INSERT INTO comments (creator, request, create_date, type, remark) 
                           VALUES ('$user_id', '$req_id', sysdate(), 'PUB', '$com_remark')");  


?>
