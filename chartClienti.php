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
    $today=getdate();
    $year1= $today[YEAR];
    $year2=	$today[YEAR]-UNO;
    $year3= $today[YEAR]-DUE;
    $year4= $today[YEAR]-TRE;
    $year5= $today[YEAR]-QUATTRO;
    $year6= $today[YEAR]-CINQUE;
    $year7= $today[YEAR]-SEI;
    $year8= $today[YEAR]-SETTE;  
    $date= array($year8, $year7, $year6, $year5, $year4, $year3, $year2, $year1);
    
    if(empty($conn) === true){
    	$conn = new mysqli($servername, $user, $pass, $database);
    }
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year1);
    $result = $conn->query($query);
    $clienti1 = $result->num_rows;
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year2);
    $result = $conn->query($query);
    $clienti2 = $result->num_rows;
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year3);
    $result = $conn->query($query);
    $clienti3 = $result->num_rows;
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year4);
    $result = $conn->query($query);
    $clienti4 = $result->num_rows;
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year5);
    $result = $conn->query($query);
    $clienti5 = $result->num_rows;
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year6);
    $result = $conn->query($query);
    $clienti6 = $result->num_rows;
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year7);
    $result = $conn->query($query);
    $clienti7 = $result->num_rows;
    $query = sprintf("SELECT * FROM utente inner join credenziale on id=utente where permesso ='u' and year(dataregistrazione) = ".$year8);
    $result = $conn->query($query);
    $clienti8 = $result->num_rows;
    
    $clienti = array($clienti8, $clienti7, $clienti6, $clienti5, $clienti4, $clienti3, $clienti2, $clienti1);
?>