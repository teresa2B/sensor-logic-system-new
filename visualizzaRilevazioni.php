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
	<br />
	<span class="visClient">Visualizza Rilevazioni</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaRilevazioni.php" method="post">
          <span class="filtra"> Filtra per:</span>
          <input class="inputfiltro" type="text" placeholder="Id Rilevazione" id="idr" name="idr" maxlength="11" value="<?php $idr=$_POST['idr']; if(isset($idr)===true){echo htmlspecialchars($idr);}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="date" placeholder="Data Rilevazione" id="data" name="data"  value="<?php $data=$_POST['data']; if(isset($data)===true){echo htmlspecialchars($data);}?>"/>
          <input class="inputfiltro" type="text" placeholder="Id Sensore" id="ids" name="ids" maxlength="50" value="<?php $ids=$_POST['ids']; if(isset($ids)===true){echo htmlspecialchars($ids);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="Tipo Sensore" id="tipo" name="tipo" maxlength="50" value="<?php $tipo=$_POST['tipo']; if(isset($tipo)===true){echo htmlspecialchars($tipo);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="Marca Sensore" id="marca" name="marca" maxlength="50" value="<?php $marca=$_POST['marca']; if(isset($marca)===true){echo htmlspecialchars($marca);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="Nome Posizione" id="nomeposizione" name="nomeposizione" maxlength="50" value="<?php $nomeposizione=$_POST['nomeposizione']; if(isset($nomeposizione)===true){echo htmlspecialchars($nomeposizione);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <br/><br/>
          <button class="buttfiltro" name="filtroRilevazioni" value="filtroRilevazioni" type="submit" id="filtroRilevazioni">Ricerca</button>
          <button class="buttfiltro" name="scaricare" value="scaricare" type="submit" id="scaricare">Scarica pdf</button>
          
          <div class="positiontable">
          <br/><br/>
           <table class="tabellaClienti">
                <thead>
                  <tr>
                    <th>Id Rilevazione</th>
                    <th>Data Rilevazione</th>
                    <th>Ora Rilevazione</th>
                    <th>Valore Rilevazione</th>
                    <th>Id Sensore</th>
                    <th>Tipo Sensore</th>
                    <th>Marca Sensore</th>
                    <th>Nome Posizione</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    	require 'config.php';
                        $conn = '';
                        $query = '';
                        session_start();
                        $email=$_SESSION['email'];
                        $impianto=$_SESSION['impianto'];
                        $idr=$_POST['idr'];
                        $data=$_POST['data'];
                        $ids=$_POST['ids'];
                        $tipo=$_POST['tipo'];
                        $marca=$_POST['marca'];
                        $nomeposizione=$_POST['nomeposizione'];
                       if(empty($conn) === true){
    						$conn = new mysqli($servername, $user, $pass, $database);
    				   }
                        if(empty($query) === true) {
                        	$query = sprintf("SELECT rilevazione.id, rilevazione.rilevazione, sensore.id, sensore.tipo, sensore.marca, posizione.nomeposizione FROM rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario= utente.id inner join credenziale on utente.id=credenziale.utente where impianto.nomeimpianto ='%s' and credenziale.email='%s' ",mysqli_real_escape_string($conn, $impianto),mysqli_real_escape_string($conn, $email));
                        }
                        if(!empty($idr) === true) {
                        	$query = $query.sprintf(' and  rilevazione.id= '.$idr);
                        }
                        if(!empty($ids) === true) {
                        	$query = $query.sprintf(" and  sensore.id= '".$ids."'");
                        }
                        if(!empty($tipo) === true) {
                        	$query = $query.sprintf(" and  sensore.tipo= '".$tipo."'");
                        }
                        if(!empty($marca) === true) {
                        	$query = $query.sprintf(" and  sensore.marca= '".$marca."'");
                        }
                        if(!empty($nomeposizione) === true){
                           	$query = $query.sprintf(" and posizione.nomeposizione = '".$nomeposizione."'");
                        }
                        
                       $query = $query.sprintf(' order by rilevazione.id');
                      
                       $result = '';
                       if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                        	$result = $conn->query($query);
                        }    
                      
                        for($i=0; $i<$result->num_rows; $i++) {
                        	$row=mysqli_fetch_row($result);
                            if(empty($data)===false){
                            	$data1=substr($data,ZERO,QUATTRO).substr($data,CINQUE,DUE).substr($data,OTTO,DUE);
                                $data2=substr($row[UNO],ZERO,QUATTRO).substr($row[UNO],QUATTRO,DUE).substr($row[UNO],SEI,DUE);
                                if($data1===$data2){
                                	$str = '<tr>';
                                    $str = $str.'<td>'.htmlspecialchars($row[ZERO]).'</td>';
                                    $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),ZERO,QUATTRO).'-'.substr(htmlspecialchars($row[UNO]),QUATTRO,DUE).'-'.substr(htmlspecialchars($row[UNO]),SEI,DUE).'</td>';
                                    $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),OTTO,DUE).':'.substr(htmlspecialchars($row[UNO]),DIECI,DUE).'</td>';
                                    $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),DODICI).'</td>';
                                    $str = $str.'<td>'.htmlspecialchars($row[DUE]).'</td>';
                                    $str = $str.'<td>'.htmlspecialchars($row[TRE]).'</td>';
                                    $str = $str.'<td>'.htmlspecialchars($row[QUATTRO]).'</td>';
                                    $str = $str.'<td>'.htmlspecialchars($row[CINQUE]).'</td>';
                                    $str = $str.'</tr>';
                                    echo $str;
                                }
                            }else{
                                $str = '<tr>';
                                $str = $str.'<td>'.htmlspecialchars($row[ZERO]).'</td>';
                                $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),ZERO,QUATTRO).'-'.substr(htmlspecialchars($row[UNO]),QUATTRO,DUE).'-'.substr(htmlspecialchars($row[UNO]),SEI,DUE).'</td>';
                                $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),OTTO,DUE).':'.substr(htmlspecialchars($row[UNO]),DIECI,DUE).'</td>';
                               	$str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),DODICI).'</td>';
                                $str = $str.'<td>'.htmlspecialchars($row[DUE]).'</td>';
                                $str = $str.'<td>'.htmlspecialchars($row[TRE]).'</td>';
                                $str = $str.'<td>'.htmlspecialchars($row[QUATTRO]).'</td>';
                                $str = $str.'<td>'.htmlspecialchars($row[CINQUE]).'</td>';
                                echo $str;
                            }
                        }
                    ?>                    
                </tbody>
            </table>
           </div>
           <br /><br />
           <hr class="separator">
           <br />
           <span class='filtra'>Inserisci l'indirizzo email a cui inviare il pdf con i dati delle rilevazioni</span>
           <input class="inputfiltro" type="text" placeholder="Email" id="email10" name="email10" maxlength="50" value="<?php $email10=$_POST['email10']; if(isset($email10)===true){echo htmlspecialchars($email10);}?>" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve rispettare il formato corretto" />
           <button class="buttfiltro" name="inviare" value="inviare" type="submit" id="inviare">invia pdf</button>
         
            
         </form>
      </div>
                  	<?php
                  
                $str = '<div id="error" class="filtra">Impossibile inviare l'."'".'email</div>';
                
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'failed') {
                	echo $str;
				}
           		?>
                            	<?php
                $str = '<div id="error" class="filtra">E-mail con allegato inviata con successo</div>';
                
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'success') {
                	echo $str;
				}
           		?>
      <?php
     
      	if(isset($_POST['scaricare'])===true){
        	$_SESSION['idr']=$_POST['idr'];
        	$_SESSION['data']=$_POST['data'];
            $_SESSION['ids']=$_POST['ids'];
            $_SESSION['tipo']=$_POST['tipo'];
            $_SESSION['marca']=$_POST['marca'];
            $_SESSION['nomeposizione']=$_POST['nomeposizione'];
            header('location:rilevazionipdf.php');
        }        
      ?>
      <?php
      
      	if(isset($_POST['inviare'])===true){
        var_dump($_POST['inviare']);
        session_start();
        	$_SESSION['idr']=$_POST['idr'];
        	$_SESSION['data']=$_POST['data'];
            $_SESSION['ids']=$_POST['ids'];
            $_SESSION['tipo']=$_POST['tipo'];
            $_SESSION['marca']=$_POST['marca'];
            $_SESSION['nomeposizione']=$_POST['nomeposizione'];
            $_SESSION['destinatario']=$_POST['email10'];
            
            header('location:inviapdf.php');
        }        
      ?>
</body>
</html>