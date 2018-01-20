<?php
	require 'config.php';
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
    <form class="form"  action="rimuovereRilevazioni.php" method="post">
    	<br />
    	<span class="visClient">Rimuovere una rilevazione</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Rilevaione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Rilevazione" id="id" name="id" maxlength="50" value="<?php $id=$_POST['id']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
        <br /><br/><br />
        <?php
        	require 'config.php';
        	session_start();
            $email=$_SESSION['email'];
            $impianto=$_SESSION['impianto'];
        	if(isset($_POST['rimuovere'])===true){
            	$conn = new mysqli($servername, $user, $pass, $database);
            	$id = $_POST['id'];
                $query=sprintf("SELECT * FROM rilevazione WHERE id='%s'",mysqli_real_escape_string($conn, $id));
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
                if($result->num_rows === 1){
                	$query=sprintf("delete rilevazione FROM rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario= utente.id inner join credenziale on utente.id=credenziale.utente where rilevazione.id='%s' and impianto.nomeimpianto ='%s' and credenziale.email='%s'",mysqli_real_escape_string($conn, $id),mysqli_real_escape_string($conn, $impianto),mysqli_real_escape_string($conn, $email));
                    $result = '';
                	if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                		$result = $conn->query($query);
                	}  
      
                    if(!($result === false) === true) {
                        $str = '<span class="filtra">Rivelazione rimossa con successo</span>';
                        echo htmlspecialchars($str);
                    } else {
                    	$str = '<span class="filtra">Rivelazione non rimossa, si è verificato un problema</span>';
                        echo htmlspecialchars($str);
                    }
                } else {
                	$str = '<span class="filtra">Rivelazione non rimossa, nessuna rilevazione ha ID: '.$id.'</span>';
                    echo htmlspecialchars($str);
                }
            }
        ?>
    	<button class="buttfiltro" name="rimuovere" value="rimuovere" type="submit" id="rimuovere">Rimuovi Rilevazione</button>
    </form>
</body>
</html>