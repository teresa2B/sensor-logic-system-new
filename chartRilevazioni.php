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
    $query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'", mysqli_real_escape_string($conn, $email), mysqli_real_escape_string($conn, $password));
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
    $rilevazioni=array();
    $countTipo=0;
 	$today=getdate();
    $date=$today['year'];
    
    if($today[MON]<DIECI){
    	$date=$date.'0'.$today['mon'];
    }else {
    	$date=$date.$today['mon'];
    }
    if($today[MDAY]<DIECI){
    	$date=$date.'0'.$today['mday'];
    }else{
    	$date=$date.$today['mday'];
    }
                                           
    if(empty($conn) === true){
    	$conn = new mysqli($servername, $user, $pass, $database);
    }
    $query=sprintf("SELECT sensore.tipo, count(sensore.tipo) FROM sensore inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where impianto.nomeimpianto='%s' and email ='%s' group by sensore.tipo order by count(sensore.tipo) desc", mysqli_real_escape_string($conn, $impianto), mysqli_real_escape_string($conn, $email));
    $result=$conn->query($query);
    $countTipo=$result->num_rows;
    if($countTipo>=CINQUE){
    	for($i=0;$i<CINQUE;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= htmlspecialchars($row[0]);
        }
    }else{
    	for($i=0;$i<$result->num_rows;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= htmlspecialchars($row[0]);
        }
    }
    
    for($i=0;$i<$countTipo;$i++){
    	$query=sprintf("select rilevazione from rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where nomeimpianto='%s' and email='%s' and sensore.tipo='%s'", mysqli_real_escape_string($conn, $impianto), mysqli_real_escape_string($conn, $email), mysqli_real_escape_string($conn, $tipo[$i]));
    	$result = '';
        if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
        	$result = $conn->query($query);
        }  
        $rilevazioni[$i]=0;
         for($l=0; $l<$result->num_rows; $l++){
            $row=mysqli_fetch_row($result);
            $date2=substr(htmlspecialchars($row[ZERO]),ZERO,OTTO);
			if($date===$date2){
    			$rilevazioni[$i]++;
      		}
     	}   
    }
    
?>