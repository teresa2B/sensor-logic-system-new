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
	<span class="visClient">Visualizza Sensori</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaSensori.php" method="post">
          <span class="filtra"> Filtra per:</span>
          <input class="inputfiltro" type="text" placeholder="Id" id="id" name="id" maxlength="50" value="<?php $id=$_POST['id']; if(isset($id)===true){echo htmlspecialchars($id);}?>"  pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="TipoSensore" id="tipo" name="tipo" maxlength="50" value="<?php $tipo=$_POST['tipo']; if(isset($tipo)===true){echo htmlspecialchars($tipo);}?>" />
          <input class="inputfiltro" type="text" placeholder="Marca" id="marca" name="marca" maxlength="50" value="<?php $marca=$_POST['marca']; if(isset($marca)===true){echo htmlspecialchars($marca);}?>" />
          <input class="inputfiltro" type="text" placeholder="Posizione" id="posizione" name="posizione" maxlength="11" value="<?php $posizione=$_POST['posizione']; if(isset($posizione)===true){echo htmlspecialchars($posizione);}?>" pattern="[0-9]{0,11}" title="Deve essere composto da soli numeri "/>
          
          <button class="buttfiltro" name="filtro" value="filtro" type="submit" id="filtro">Ricerca</button>
          <div class="positiontable">
           <table class="tabellaClienti">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>TipoSensore</th>
                    <th>Marca</th>
                    <th>Posizione</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    	require 'config.php';
                        $conn = '';
                        $id=$_POST['id'];
                        $tipo=$_POST['tipo'];
                        $marca=$_POST['marca'];
                        $posizione=$_POST['posizione'];
                        
                        $query = sprintf("SELECT * FROM sensore inner join posizione on sensore.posizione= posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario= utente.id inner join credenziale on utente.id=credenziale.utente where permesso='u'");
                        if(!empty($id) === true) {
                        	$query = $query.sprintf(" and sensore.id = '".$id."'");
                        }
                        if(!empty($tipo) === true){
                           	$query = $query.sprintf(" and sensore.tipo = '".$tipo."'");
                        }
                        if(!empty($marca) === true){
                           	$query = $query.sprintf(" and sensore.marca = '".$marca."'");
                        }
                        if(!empty($posizione) === true){
                           	$query = $query.sprintf(" and sensore.posizione = '".$posizione."'");
                        }
          				$query=$query.sprintf(' order by sensore.id');
                        
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
                            $str = $str.'<td>'.htmlspecialchars($row[0]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[1]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[DUE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[TRE]).'</td>';
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