<html>
<head>
  <meta charset="UTF-8">
  <title>Sensor Logic System</title>
  <meta name="viewport" content="width=320">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="credentialDesktop.css" media="only screen and (min-width: 401px)" rel="stylesheet" type="text/css">
  <link href="credentialMobile.css" media="only screen and (max-width: 400px)" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="wrapper">
	  <div class="container">
			<div class="logo">Sensor Logic System</div><br>
		  	<div> Inserisci la tua email per ricevere le tue credenziali d'accesso </div><br>
            
			<form class="form"  action="sendEmail.php" method="post">
				<input type="text" placeholder="Email@dominio.com" id="email" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve contenere un'e-mail valida" required>
                <?php
                $failed = '<div id="error">Email non valida</div>';
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'failed') {
                	echo $failed;
				}
           		?>
                <?php
                $success = '<div id="success">Email inviata con successo</div>';
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'success') {
                	echo $success;
				}
           		?>
                <br>
				<button name="submit" value="confirmation" type="submit" id="confirmation">Conferma</button>
	    </form>
	  </div>
	</div>
</body>

</html>
