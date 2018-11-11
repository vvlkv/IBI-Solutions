<?php 
include("auth.php"); 

$user_id = $_SESSION['UID'];
$req_id = $_POST['tmp_id'];

$result = $db->query("DELETE FROM tmp_requests WHERE id='$req_id'");
header("location: tmp_requests.php");//перенаправление	

				   
?>
