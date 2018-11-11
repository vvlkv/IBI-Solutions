<?php 
include("auth.php"); 


$user_id = $_SESSION['UID'];

$tmp_req_id = $_POST['tmp'];

$area = $_POST['area_id'];
$category = $_POST['category'];
$remark = $_POST['remark'];
$job_type = $_POST['job'];
$state = "NEW";

$result = $db->query("INSERT INTO requests (create_date, creator, 
                                         location, category, remark, job_type, 
                                         state) 
                           VALUES (sysdate(), '$user_id', 
						           '$area', '$category', '$remark', '$job_type', 
								   '$state')"); 
						

if (!empty($tmp_req_id )) {
    $result = $db->query("DELETE FROM tmp_requests WHERE id='$tmp_req_id'");	
}						
?>
