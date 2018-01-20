<?php
	require 'config.php';
    
	session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    $conn = '';

    if($conn === '') {
        $conn = new mysqli($servername, $user, $pass, $database);
    }

    $query = sprintf("SELECT * FROM credenziale WHERE email = '%s' AND password = '%s'", mysqli_real_escape_string($conn, $email), mysqli_real_escape_string($conn, $password));
    $result = $conn->query($query);
    if($result === false || $result->num_rows !== 1){
    	    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
    }
?>
<?php
session_start();
if(session_destroy() === true) {
	header('Location: index.php');
}
?>
