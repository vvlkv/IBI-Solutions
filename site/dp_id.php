<?php 
include("auth.php"); 

$user_id = $_SESSION['UID'];
$dp_id = $_POST['doc'];
$_SESSION['dp_id'] = $dp_id;
header("location: documents.php");//перенаправление	

				   
?>
