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
	<span class="visClient">Visualizza Impianti</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaImpianti.php" method="post">
          <span class="filtra"> Filtra per:</span>
          <input class="inputfiltro" type="text" placeholder="IdImpianto" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="text" placeholder="NomeImpianto" id="nomeimpianto" name="nomeimpianto" maxlength="50" value="<?php $nomeimpianto=$_POST['nomeimpianto']; if(isset($nomeimpianto)===true){echo htmlspecialchars($nomeimpianto);}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" />
          <input class="inputfiltro" type="text" placeholder="IdProprietario" id="idproprietario" name="idproprietario" maxlength="11" value="<?php $idproprietario=$_POST['idproprietario']; if(isset($idproprietario)===true){echo htmlspecialchars($idproprietario);}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="text" placeholder="Tipo" id="tipo" name="tipo" maxlength="50" value="<?php $tipo=$_POST['tipo']; if(isset($tipo)===true){echo htmlspecialchars($tipo);}?>"  pattern="[A-Za-z]{0,50}" title="Deve contenere solo lettere"/>
          <input class="inputfiltro" type="text" placeholder="Città" id="citta" name="citta" maxlength="50" value="<?php $citta=$_POST['citta']; if(isset($citta)===true){echo htmlspecialchars($citta);}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composta da sole lettere" />
          <button class="buttfiltro" name="filtro" value="filtro" type="submit" id="filtro">Ricerca</button>
          <div class="positiontable">
           <table class="tabellaClienti">
                <thead>
                  <tr>
                    <th>IdImpianto</th>
                    <th>NomeImpianto</th>
                    <th>IdProprietario</th>
                    <th>Città</th>
                    <th>Indirizzo</th>
                    <th>N°Civico</th>
                    <th>Provincia</th>
                    <th>CAP</th>
                    <th>Tipo</th>
                    <th>Descrizione</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    	require 'config.php';
                        $conn = '';
                        $id=$_POST['id'];
                        $nomeimpianto=$_POST['nomeimpianto'];
                        $idproprietario=$_POST['idproprietario'];
                        $tipo=$_POST['tipo'];
                        $citta=$_POST['citta'];
                        
                        $query = sprintf("SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where permesso='u'");
                        if(!empty($id) === true) {
                        	$query = $query.sprintf(' and impianto.id = '.$id);
                        }
                        if(!empty($nomeimpianto) === true){
                           	$query = $query.sprintf(" and nomeimpianto = '".$nomeimpianto."'");
                        }
                        if(!empty($idproprietario) === true){
                           	$query = $query.sprintf(" and utente.id = '".$idproprietario."'");
                        }
                        if(!empty($tipo) === true){
                           	$query = $query.sprintf(" and tipo = '".$tipo."'");
                        }
                        if(!empty($citta) === true){
                           	$query = $query.sprintf(" and impianto.citta = '".$citta."'");
                        }
                        $query=$query.sprintf(' order by impianto.id');
                        
                        if($conn === '') {
    						$conn = new mysqli($servername, $user, $pass, $database);
						}
                        $result = '';
                        if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                        	$result = $conn->query($query);
                        }  
                       
                        for($i=0; $i<$result->num_rows; $i++) {
                        	$row=mysqli_fetch_row($result);
                            
                        	$str = '<tr>';
                            $str = $str.'<td>'.htmlspecialchars($row[ZERO]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[DUE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[UNO]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[TRE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[QUATTRO]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[CINQUE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[SEI]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[SETTE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[NOVE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[OTTO]).'</td>';
                            $str = $str.'</tr>';
                            echo $str;
                        }
                    ?>
                </tbody>
            </table>
           </div>
         </form>
      </div>
</body>
</html>