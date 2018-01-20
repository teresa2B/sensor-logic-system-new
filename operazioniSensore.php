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
    $query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'",mysqli_real_escape_string($conn, $email),  mysqli_real_escape_string($conn, $password));
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
	<form class="form"  action="operazioniSensore.php" method="post">
    	<br />
    	<span class="visClient">Registrare un nuovo sensore</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID Posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Posizione" id="idposizione" name="idposizione" maxlength="11" value="<?php $id=$_POST['idposizione']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
            	<tr>
                	<td><span class="filtra2">Tipologia</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Tipologia sensore" id="tipo" name="tipo" maxlength="50" value="<?php $tipo=$_POST['tipo']; if(isset($tipo)===true){echo htmlspecialchars($tipo);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
              </tbody>
          </table>
        </div>
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                    <tr>
                    	<td><span class="filtra2">Marca</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Marca" id="marca" name="marca" maxlength="50" value="<?php $marca=$_POST['marca']; if(isset($marca)===true){echo htmlspecialchars($marca);}?>"  pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                  	</tr>
                </tbody>
            </table>
        </div>
        <br /><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['aggiungere'])===true){
            	$idposizione = $_POST['idposizione'];
            	$query=sprintf("SELECT * from posizione WHERE id='%s'".$idposizione,mysqli_real_escape_string($conn, $idposizione));
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
            	if($result->num_rows === 0){
                	$str = '<span class="filtra">Non è presente nessuna posizione con ID: '.$idposizione.'</span>';
                    echo htmlspecialchars($str);
                } else {
                    $tipo= $_POST['tipo'];
                    $marca= $_POST['marca'];
                    $query=sprintf("select * from sensore where tipo='%s' and marca ='%s'",mysqli_real_escape_string($conn, $tipo),  mysqli_real_escape_string($conn, $marca));
                	$result = '';
                	if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                		$result = $conn->query($query);
                	}  
                    $count=$result->num_rows+1;
                    $id=substr($tipo, ZERO,TRE).substr($marca,ZERO,TRE).$count;
                	$query=sprintf("insert into sensore (id, tipo, marca, posizione) values ('%s','%s','%s','%s')",mysqli_real_escape_string($conn, $id),  mysqli_real_escape_string($conn, $tipo),mysqli_real_escape_string($conn, $marca),  mysqli_real_escape_string($conn, $idposizione));
                	$result = '';
                	if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                		$result = $conn->query($query);
                	}  
                    if($result === false){
                    	$str = '<span class="filtra">Registrazione non riuscita</span>';
                        echo $str;
                    } else {
                    	$str = '<span class="filtra">Registrazione riuscita</span>';
                        echo $str;
                    }
                }
        	}
        ?>
       	<br />
    	<button class="buttfiltro" name="aggiungere" value="aggiungere" type="submit" id="aggiungere">Registra sensore</button>
	</form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniSensore.php" method="post">
    	<br />
    	<span class="visClient">Rimuovere un sensore</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Sensore</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID sensore" id="id" name="id" maxlength="50" value="<?php $id=$_POST['id']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
        <br /><br/><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['rimuovere'])===true){
            	$id = $_POST['id'];
                $conn = new mysqli($servername, $user, $pass, $database);
                $query=sprintf("SELECT * FROM sensore WHERE id='%s'",mysqli_real_escape_string($conn, $id));
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
                if($result->num_rows === 1){
                	$query=sprintf("DELETE FROM sensore WHERE id='%s'",mysqli_real_escape_string($conn, $id));
                	$result = '';
                	if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                		$result = $conn->query($query);
                	}  
                    if(!($result === false) === true) {
                        $str = '<span class="filtra">Sensore rimosso con successo</span>';
                        echo htmlspecialchars($str);
                    } else {
                    	$str = '<span class="filtra">Sensore non rimosso, si è verifica un problema</span>';
                        echo htmlspecialchars($str);
                    }
                } else {
                	$str = '<span class="filtra">Sensore non rimosso, nessun sensore ha ID: '.$id.'</span>';
                    echo htmlspecialchars($str);
                }
            }
        ?>
    	<button class="buttfiltro" name="rimuovere" value="rimuovere" type="submit" id="rimuovere">Rimuovi sensore</button>
    </form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniSensore.php" method="post">
    	<br />
    	<span class="visClient">Modificare i dati del sensore</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Sensore</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Sensore" id="id2" name="id2" maxlength="50" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
    	<button class="buttfiltro" name="recuperare" value="recuperare" type="submit" id="recuperare">Recupera i dati del sensore</button>
    </form>
    <br /><br />
	<form class="form"  action="operazioniSensore.php" method="post">
    	<br />
        <?php
        	require 'config.php';
            
            if(isset($_POST['recuperare'])===true){
            	$id = $_POST['id2'];
                $conn = new mysqli($servername, $user, $pass, $database);
                $query=sprintf("SELECT * FROM sensore WHERE id='%s'",mysqli_real_escape_string($conn, $id));
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
                if($result->num_rows === 1){
                	$str = '<span class="filtra">Recuperati i dati del sensore con ID: '.$id.'</span>';
                    echo htmlspecialchars($str);
                } else {
                	$str = '<span class="filtra">Non è presente nessun sensore con ID: '.$id.'</span>';
                    echo htmlspecialchars($str);
                }
            }
        ?>
        <br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID Posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Posizione" id="idposizione2" name="idposizione2" maxlength="11" 
                    	value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$id2 = $_POST['id2'];
                                    $conn = new mysqli($servername, $user, $pass, $database);
                                	$query=sprintf("SELECT * FROM sensore WHERE id='%s'",mysqli_real_escape_string($conn, $id2));
                					$result = '';
                					if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                						$result = $conn->query($query);
                					}  
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo htmlspecialchars($row[TRE]);
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$idposizione=$_POST['idposizione2'];
                            		if(isset($idposizione)===true){
                            			echo htmlspecialchars($idposizione);
                           	 		}
                                }}
                       		?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
            	<tr>
                	<td><span class="filtra2">Tipologia</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Tipologia sensore" id="tipo2" name="tipo2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$id2 = $_POST['id2'];
                                    $conn = new mysqli($servername, $user, $pass, $database);
                                	$query=sprintf("SELECT * FROM sensore WHERE id='%s'",mysqli_real_escape_string($conn, $id2));                					
                					$result = '';
                                    if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                                        $result = $conn->query($query);
                                    }  
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo htmlspecialchars($row[1]);
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$tipo=$_POST['tipo2'];
                            		if(isset($tipo)===true){
                            			echo htmlspecialchars($tipo);
                           	 		}
                                }}
                       		?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
              </tbody>
          </table>
        </div>
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                    <tr>
                    	<td><span class="filtra2">Marca</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Marca" id="marca2" name="marca2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$id2 = $_POST['id2'];
                                	$conn = new mysqli($servername, $user, $pass, $database);
                                	$query=sprintf("SELECT * FROM sensore WHERE id='%s'",mysqli_real_escape_string($conn, $id2));                					
                                    $result = '';
                                    if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                                        $result = $conn->query($query);
                                    }  
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo htmlspecialchars($row[DUE]);
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$marca=$_POST['marca2'];
                            		if(isset($marca)===true){
                            			echo htmlspecialchars($marca);
                           	 		}
                                }}
                       		?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                  	</tr>
                </tbody>
            </table>
        </div>
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['salvare'])===true){
                $idposizione = $_POST['idposizione2'];
                $tipo= $_POST['tipo2'];
                $marca= $_POST['marca2'];
                $query=sprintf("select* from sensore where tipo='%s' and marca ='%s'",mysqli_real_escape_string($conn, $tipo),mysqli_real_escape_string($conn, $marca));
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
                $count=$result->num_rows+1;
                $id=substr($tipo, ZERO,TRE).substr($marca,ZERO,TRE).$count;
                $id2 = $_POST['id2'];
                $conn = new mysqli($servername, $user, $pass, $database);
            	$query=sprintf("UPDATE sensore SET id='%s, tipo='%s', marca='%s', posizione='%s' WHERE id='%s'",mysqli_real_escape_string($conn, $id),mysqli_real_escape_string($conn, $tipo),mysqli_real_escape_string($conn, $marca),mysqli_real_escape_string($conn, $idposizione),mysqli_real_escape_string($conn, $id2));       
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
				if($result === false) {
                	$str = '<span class="filtra">Impossibile salvare, controllare le modifiche effettuate</span>';
                    echo htmlspecialchars($str);
                } else {
                	$str = '<span class="filtra">Modifiche salvate con successo</span>';
                    echo htmlspecialchars($str);
                }
        	}
        ?>
       	<br /><br />
    	<button class="buttfiltro" name="salvare" value="salvare" type="submit" id="salvare" 
        	<?php 
           		require 'config.php';
                $conn = '';
                $query = '';
        		$id=$_POST['id2']; 
                if(isset($id)===false){
                	echo ' disabled ';
                }
                if(empty($query) === true) {
                	$query=sprintf("SELECT * FROM sensore WHERE id='%s'",mysqli_real_escape_string($conn, $id));
                }
                if(empty($conn) === true){
    				$conn = new mysqli($servername, $user, $pass, $database);
    			}
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
                if($result->num_rows !== 1){
                	echo ' disabled ';
                }
        	?> 
        >Salva i dati del sensore</button>
        <input type="hidden" name="id2" id="id2" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo htmlspecialchars($id);}?>">
	</form>
</body>
</html>