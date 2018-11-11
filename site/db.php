<?php

include_once 'restapi/sql.php';
$database = new Database();
$db = $database->getConnection();
/*define('DB_TYPE', 'mysql');
define('DB_HOST', 'ouchsu00.mysql');
define('DB_PORT', 3306);
define('DB_NAME', 'ouchsu00_vkapi');
define('DB_USERNAME', 'ouchsu00_vkapi');
define('DB_PASSWORD', 'Vkapi123');

$dsn = DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT;

try {
	$db = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
} catch (PDOException $e) {
	echo $e->getMessage();
	print_r($e->getTrace());
}*/
?>
