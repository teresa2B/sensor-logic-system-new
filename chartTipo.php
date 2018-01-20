<?php
	require 'config.php';
    require 'constants.php';
    $conn = '';
	session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if(empty($conn) === true){
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
    $conn = '';
    session_start();
    $email=$_SESSION['email'];
    $impianto=$_SESSION['impianto'];
    $tipo=array();
    $countTipo=array();
    
    if(empty($conn) === true){
    	$conn = new mysqli($servername, $user, $pass, $database);
    }
    $query=sprintf("SELECT sensore.tipo, count(sensore.tipo) FROM sensore inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where impianto.nomeimpianto='%s' and email ='%s' group by sensore.tipo order by count(sensore.tipo) desc",mysqli_real_escape_string($conn, $impianto),mysqli_real_escape_string($conn, $email));
    $result=$conn->query($query);
   
    if($result->num_rows>=CINQUE){
    	for($i=ZERO;$i<CINQUE;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= htmlspecialchars($row[0]);
            $countTipo[$i]=htmlspecialchars($row[1]);
        }
    }else{
    	for($i=0;$i<$result->num_rows;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= htmlspecialchars($row[0]);
            $countTipo[$i]= htmlspecialchars($row[1]);
        }
    }
?>