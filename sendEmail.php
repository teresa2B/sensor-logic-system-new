<?php
	require 'config.php';
    require 'constants.php';
    
    $conn = '';
	session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if($conn === '') {
    	$conn = new mysqli($servername, $user, $pass, $database);
	}
    $query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'",mysqli_real_escape_string($conn, $email),mysqli_real_escape_string($conn, $password));
    $result = $conn->query($query);
    if($result === false || $result->num_rows !== 1){
    	    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
    }
?>
<?php
require 'config.php';
require 'nocsrf.php';
$csrf = new nocsrf();

$nome_mittente = 'SensorLogicSystem';
$mail_mittente = 'sensorlogicsystem@gmail.com';
$mail_oggetto = 'Recupero credenziali';
$mail_headers = 'From: ' .  $nome_mittente . ' <' .  $mail_mittente . '>\r\n';
$mail_headers .= 'Reply-To: ' .  $mail_mittente . '\r\n';

$mail_destinatario = $_POST['email'];
$result = false;
$mail_corpo = '';
$conn = '';

if(!filter_var($mail_destinatario, FILTER_VALIDATE_EMAIL) === false && isset($_SESSION['email']) === true) {
	$conn = new mysqli($servername, $user, $pass, $database);
	$query = sprintf("select password from credenziale where email= '%s'", mysqli_real_escape_string($conn, $mail_destinatario));
	$result = $conn->query($query);
	$row = $result->fetch_assoc();
    $mail_corpo = 'Gentile utente, ecco di seguito le credenziali da te richieste: password: ' . $row['password'];
}

$regexemail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
$send = false;

if (preg_match($regexemail, $mail_destinatario) === 1 && $result->num_rows === 1) {	
	if($csrf->check(CSRF, $_POST, false, SIZE, true) === true){
    	$send = mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers);
    }
}	

if($send === true) {
	header('Location: http://sensorlogicsystemlogin.altervista.org/credential.php?msg=success');
} else {
	header('Location: http://sensorlogicsystemlogin.altervista.org/credential.php?msg=failed');
}

$conn->close();