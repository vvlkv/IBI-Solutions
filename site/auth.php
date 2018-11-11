<?php
include("db.php");
session_start();
	 
function Destroy() {
	unset($_SESSION['UID']);
    unset($_SESSION['USERNAME']);
    header("location: index.php");
}
	 
if(isset($_SESSION['UID']) && isset($_SESSION['USERNAME'])) {
	$UID = $_SESSION['UID'];
    $EMAIL = $_SESSION['USERNAME'];
	try {
		$result = $db->query("SELECT * FROM users WHERE id = '$UID' AND email = '$EMAIL'");
	} catch (PDOException $e) {
		echo $e->getMessage();
	    Destroy(); 
	}
} else { 
	Destroy(); 
}
?>
