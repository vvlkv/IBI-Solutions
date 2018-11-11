<?php 
include("auth.php"); 

$user_id = $_SESSION['UID'];
$req_id = $_POST['req_id'];
$state= $_POST['state_code'];
$result = $db->query("UPDATE requests 
                         SET state = '$state'
					   WHERE id = '$req_id'");  

?>
