<?php 
include("auth.php"); 

$user_id = $_SESSION['UID'];
$req_id = $_POST['req_id'];
$executer= $_POST['executer_id'];
$result = $db->query("UPDATE requests 
                         SET executer = '$executer',
						     state = 'SET'
					   WHERE id = '$req_id'");  

?>
