<?php
require 'config.php';

$email=$_POST['email'];
$password=$_POST['password'];
$conn = '';
$result = '';

if(!isset($_SESSION['email']) === true) {
    $conn = new mysqli($servername, $user, $pass, $database);
	$query = sprintf("select permesso from credenziale where password = '%s' AND email = '%s'",
 	mysqli_real_escape_string($conn, $password),
 	mysqli_real_escape_string($conn, $email));
	$result = $conn->query($query);
}

if($result->num_rows === 1) {
	session_start();
	$_SESSION['email'] = $email;
	$_SESSION['password'] = $password;
    $row = mysqli_fetch_row($result);
    $permesso = $row[0];
    if($permesso === 'a') {
        header('Location: http://sensorlogicsystemlogin.altervista.org/admin.php');
    }
    if($permesso === 't') {
    	header('Location: http://sensorlogicsystemlogin.altervista.org/tecnico.php');
    }
    if($permesso === 'u') {
    	header('Location: http://sensorlogicsystemlogin.altervista.org/cliente.php');
    }
} else {
    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php?msg=failed');
}
   
$conn->close();
