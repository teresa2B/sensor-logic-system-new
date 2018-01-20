<?php
	require 'config.php';
    require 'nocsrf.php';
    require 'constants.php';
    
	$csrf = new nocsrf();
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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="generator" content="AlterVista - Editor HTML"/>
  <title></title>
  <link href="adminDesktop.css" media="only screen and (min-width: 401px)" rel="stylesheet" type="text/css">
  <link href="adminMobile.css" media="only screen and (max-width: 400px)" rel="stylesheet" type="text/css">
 
</head>
<body>
	<br/><br/>
	<span class="visClient"> Supporto clienti</span>
    <br/><br/>
    <span class="filtra">Contattaci! Scrivi qui il tuo messaggio e il nostro team ti contatteranno al più presto</span>
    <br/><br/><br/>
    <form class="form"  action="supporto.php" method="post">
      <textarea class="problem" name='text' id='text' placeholder="Spiegaci il tuo problema..." rows="20" required ></textarea>
      		<?php
                $success = '<span class="filtra" id="msg" >Email inviata con successo</span>';
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'success') {
                 	echo $success;
    			}
     		?>
     		<?php
                $failed = '<span class="filtra" id="msg" >Email non inviata</span>';
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'failed') {
                 	echo $failed;
    			}
             ?>
      <button class="buttfiltro" name="invia" value="invia" type="submit" id="invia">Invia</button>
    </form>
    <?php
    	if(isset($_POST['invia'])===true){
        		session_start();
                
                $regexemail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                
        		$mail_mittente = $_SESSION['email'];
                $mail_oggetto = 'SupportoCliente';
                $mail_headers = '';
                if (preg_match($regexemail, $mail_mittente) === 1) {
                    $mail_headers = 'From: ' .  $mail_mittente . '>\r\n';
               		$mail_headers .= 'Reply-To: ' .  $mail_mittente . '\r\n';
                }	                          

                $mail_destinatario = 'sensorlogicsystem@gmail.com';
                $result = false;
                $mail_corpo = '';
                $conn = '';
				$mail_corpo='';
                if(isset($_POST['text'])===true){
                	$mail_corpo=$_POST['text'];
                }

                $send = false;

                if (preg_match($regexemail, $mail_destinatario) === 1) {
                	if($csrf->check(CSRF, $_POST, false, SIZE, true) === true){
                    	$send = mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers);
                    }
                }	

                if($send === true) {
                    header('Location: http://sensorlogicsystemlogin.altervista.org/supporto.php?msg=success');
                } else {
                    header('Location: http://sensorlogicsystemlogin.altervista.org/supporto.php?msg=failed');
                }

                $conn->close();
        }
        
    ?>
</body>
</html>