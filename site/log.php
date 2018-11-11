<?php
include("db.php"); //соединение с SQL
session_start(); //начало сессии для записи
	 
$errmsg = array(); //массив для сохранения ошибок
$errflag = false; //флаг ошибки
$email = $_POST['email']; //имя пользователя
$password = $_POST['password']; //пароль
	
//проверка имени пользователя
if($email == '') {
	$errmsg[] = 'Email missing'; //ошибка
	$errflag = true; //поднимает флаг в случае ошибки
}
	 
//проверка пароля
if($password == '') {
	$errmsg[] = 'Password missing'; //ошибка
	$errflag = true; //поднимает флаг в случае ошибки
}
	
//если флаг ошибки поднят, направляет обратно к форме регистрации
if($errflag) {
	$_SESSION['ERRMSG'] = $errmsg; //записывает ошибки
    session_write_close(); //закрытие сессии
    header("location: login.php"); //перенаправление
    exit();
}
	 
//запрос к базе данных
try {	
	$result = $db->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$_SESSION['UID'] = $row['id']; //получение UID из базы данных и помещение его в сессию
        $_SESSION['USERNAME'] = $email;//устанавливает, совпадает ли имя пользователя с сессионным 
        session_write_close(); //закрытие сессии
        header("location: start.php");//перенаправление
    }
} catch (PDOException $e) {
    $_SESSION['ERRMSG'] = "Invalid username or password"; //ошибка
    session_write_close(); //закрытие сессии
    header("location: login.php"); //перенаправление
    exit(); 
}
?>
