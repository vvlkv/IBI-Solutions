<?php 
include("auth.php"); 

$user_id = $_SESSION['UID'];
$area_id = $_POST['area_id'];
$job = $_POST['job'];
$begin_dt = $_POST['begin_dt'];
$end_dt = $_POST['end_dt'];

$result = $db->query("INSERT INTO areas_book (creator, area, begin_dt, end_dt, job_type) 
                           VALUES ('$user_id', '$area_id', $begin_dt, $end_dt, '$job')");  


?>
