<?php  
include("auth.php");
$user_id = $_SESSION['UID'];
$request_id = isset($_GET['id']) ? $_GET['id'] : die();




$requests = $db->query("SELECT tr.*, a.name as area_name
                          FROM  tmp_requests tr,
					              areas a
                         WHERE coalesce(tr.location, '-1') = a.id
				           AND tr.id = $request_id ");  
						   

				 
while($row = $requests->fetch(PDO::FETCH_ASSOC)) 
{ 
    $image = $row['photo_url'];
	header('Content-type: image/jpeg');
     echo $image;
}
?>