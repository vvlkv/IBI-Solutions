<?php
session_start();
unset($_SESSION['UID']);
unset($_SESSION['USERNAME']);
header("location: index.php");
?>
