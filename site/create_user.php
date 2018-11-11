<?php 
include("auth.php"); 

$user_id = $_SESSION['UID'];

$vk_id = $_POST['vk_id'];
$email = $_POST['email'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$password = $_POST['passw'];
$birth = $_POST['birth'];
$area = $_POST['area_id'];
$timetable = $_POST['timetable'];
$post = $_POST['post'];
$category = $_POST['category'];
$selfphone = $_POST['selfphone'];
$workphone = $_POST['workphone'];
$status = "WRK";

$result = $db->query("INSERT INTO users (reg_date, status, 
                                         vk_id, name, lastname, self_phone, 
                                         work_phone, email, password, 
										 post, category, area, timetable) 
                           VALUES (sysdate(), '$status', 
						           '$vk_id', '$name', '$lastname', '$selfphone', 
								   '$workphone', '$email', '$password', 
								   '$post', '$category', '$area', '$timetable')"); 
/*$result = $db->query("INSERT INTO users (reg_date, status,
                                         vk_id)
                           VALUES (sysdate(), '$status',
						           '$vk_id')");	*/							

				   
?>
