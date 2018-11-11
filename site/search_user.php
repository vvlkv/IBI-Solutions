<?php 
include("auth.php"); 
$user_id = $_SESSION['UID'];
$search_data = $_POST['search_data'];
$_SESSION['search_data'] = $search_data;
header("location: find_users.php");//перенаправление	
				   
?>
