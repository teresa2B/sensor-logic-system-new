<html>
<head>
  <meta charset="UTF-8">
  <title>Sensor Logic System</title>
  <meta name="viewport" content="width=320">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="indexDesktop.css" media="only screen and (min-width: 401px)" rel="stylesheet" type="text/css">
  <link href="indexMobile.css" media="only screen and (max-width: 400px)" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="wrapper">
	  <div class="container">
			<div class="logo">Sensor Logic System</div><br>
		
			<form class="form"  action="login.php" method="post">
            	<?php
                $str = '<div id="error">Username o password non validi</div>';
                
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'failed') {
                	echo $str;
				}
           		?>
				<input type="text" placeholder="Email@dominio.com" id="email" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve contenere un'e-mail valida" maxlength="50" required>
				<input type="password" placeholder="Password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="30" title="Deve contenere almeno un numero, una lettera maiuscola e minuscola, e minimo 8 caratteri" required>
				<a href="http://sensorlogicsystemlogin.altervista.org/credential.php">Non ricordi più come accedere all'account?</a><br><br><br>
				<button name="submit" value="login" type="submit" id="login">Login</button>
	    </form>
	  </div>
	</div>
</body>

</html>
