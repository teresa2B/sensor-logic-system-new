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
	<form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
    	<span class="visClient">Registrare una nuova posizione</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID Impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Impianto" id="idimpianto" name="idimpianto" maxlength="11" value="<?php $id=$_POST['idimpianto']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
            	<tr>
                	<td><span class="filtra2">Nome posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome posizione" id="nomeposizione" name="nomeposizione" maxlength="50" value="<?php $nome=$_POST['nomeposizione']; if(isset($nome)===true){echo htmlspecialchars($nome);}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
              </tbody>
          </table>
        </div>
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                    <tr>
                    	<td><span class="filtra2">Descrizione</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Descrizione" id="descrizione" name="descrizione" maxlength="100" value="<?php $descrizione=$_POST['descrizione']; if(isset($descrizione)===true){echo htmlspecialchars($descrizione);}?>"/></td>
                  	</tr>
                </tbody>
            </table>
        </div>
        <br /><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['aggiungere'])===true){
            	$idimpianto = $_POST['idimpianto'];
                $conn = new mysqli($servername, $user, $pass, $database);
            	$query=sprintf("SELECT * from impianto WHERE id='%s'", mysqli_real_escape_string($conn, $idimpianto));
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
            	if($result->num_rows === 0){
                	$str = '<span class="filtra">Non è presente nessun impianto con ID: '.$idimpianto.'</span>';
                    echo htmlspecialchars($str);
                } else {
                    $nomeposizione= $_POST['nomeposizione'];
                    $descrizione= $_POST['descrizione'];
                	$query=sprintf("insert into posizione (nomeposizione, descrizione, impianto) values ('%s','%s','%s')", mysqli_real_escape_string($conn, $nomeposizione), mysqli_real_escape_string($conn, $descrizione), mysqli_real_escape_string($conn, $idimpianto));
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
    	<button class="buttfiltro" name="aggiungere" value="aggiungere" type="submit" id="aggiungere">Registra posizione</button>
	</form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
    	<span class="visClient">Rimuovere una posizione</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID posizione" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
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
                $query=sprintf("SELECT * FROM posizione WHERE id='%s'", mysqli_real_escape_string($conn, $id));                
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
                if($result->num_rows === 1){
                	$query=sprintf("DELETE FROM posizione WHERE id='%s'", mysqli_real_escape_string($conn, $id));
                    $result = '';
                	if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                		$result = $conn->query($query);
                	}  
                    if(!($result === false) === true) {
                        $str = '<span class="filtra">Posizione rimossa con successo</span>';
                        echo htmlspecialchars($str);
                    } else {
                    	$str = '<span class="filtra">Posizione non rimossa, si è verifica un problema</span>';
                        echo htmlspecialchars($str);
                    }
                } else {
                	$str = '<span class="filtra">Posizione non rimossa, nessuna posizione ha ID: '.$id.'</span>';
                    echo htmlspecialchars($str);
                }
            }
        ?>
    	<button class="buttfiltro" name="rimuovere" value="rimuovere" type="submit" id="rimuovere">Rimuovi posizione</button>
    </form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
    	<span class="visClient">Modificare i dati della posizione</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Posizione" id="id2" name="id2" maxlength="11" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo htmlspecialchars($id);}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
    	<button class="buttfiltro" name="recuperare" value="recuperare" type="submit" id="recuperare">Recupera i dati della posizione</button>
    </form>
    <br /><br />
	<form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
        <?php
        	require 'config.php';
            
            if(isset($_POST['recuperare'])===true){
            	$id = $_POST['id2'];
                $conn = new mysqli($servername, $user, $pass, $database);
                $query=sprintf("SELECT * FROM posizione WHERE id='%s'", mysqli_real_escape_string($conn, $id));                
                $result = '';
                if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                	$result = $conn->query($query);
                }  
                if($result->num_rows === 1){
                	$str = '<span class="filtra">Recuperati i dati della posizione con ID: '.$id.'</span>';
                    echo htmlspecialchars($str);
                } else {
                	$str = '<span class="filtra">Non è presente nessuna posizione con ID: '.$id.'</span>';
                    echo htmlspecialchars($str);
                }
            }
        ?>
        <br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID Impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Impianto" id="idimpianto2" name="idimpianto2" maxlength="11" 
                    	value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$id2 = $_POST['id2'];
                                    $conn = new mysqli($servername, $user, $pass, $database);
                                	$query=sprintf("SELECT * FROM posizione WHERE id='%s'", mysqli_real_escape_string($conn, $id2));                					
                					$result = '';
                					if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                						$result = $conn->query($query);
                					}  
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo htmlspecialchars($row[TRE]);
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$idimpianto=$_POST['idimpianto2'];
                            		if(isset($idimpianto)===true){
                            			echo htmlspecialchars($idimpianto);
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
                	<td><span class="filtra2">Nome posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome posizione" id="nomeposizione2" name="nomeposizione2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$id2 = $_POST['id2'];
                                    $conn = new mysqli($servername, $user, $pass, $database);
                                	$query=sprintf("SELECT * FROM posizione WHERE id='%s'", mysqli_real_escape_string($conn, $id2));                					
                					$result = '';
                					if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                						$result = $conn->query($query);
                					}  
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo htmlspecialchars($row[1]);
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$nome=$_POST['nomeposizione2'];
                            		if(isset($nome)===true){
                            			echo htmlspecialchars($nome);
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
                    	<td><span class="filtra2">Descrizione</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Descrizione" id="descrizione2" name="descrizione2" maxlength="100" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$id2 = $_POST['id2'];
                                    $conn = new mysqli($servername, $user, $pass, $database);
                                	$query=sprintf("SELECT * FROM posizione WHERE id='%s'", mysqli_real_escape_string($conn, $id2));                					
                					$result = '';
                					if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                						$result = $conn->query($query);
                					}  
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo htmlspecialchars($row[DUE]);
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$descrizione=$_POST['descrizione2'];
                            		if(isset($descrizione)===true){
                            			echo htmlspecialchars($descrizione);
                           	 		}
                                }}
                       		?>" /></td>
                  	</tr>
                </tbody>
            </table>
        </div>
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['salvare'])===true){
                $idimpianto = $_POST['idimpianto2'];
                $nomeposizione= $_POST['nomeposizione2'];
                $descrizione= $_POST['descrizione2'];
                $id2=$_POST['id2'];
                $conn = new mysqli($servername, $user, $pass, $database);
            	$query=sprintf("UPDATE posizione SET nomeposizione='%s', descrizione='%s', impianto='%s' WHERE id='%s'", mysqli_real_escape_string($conn, $nomeposizione), mysqli_real_escape_string($conn, $descrizione), mysqli_real_escape_string($conn, $idimpianto), mysqli_real_escape_string($conn, $id2));                
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
                	$query=sprintf("SELECT * FROM posizione WHERE id='%s'", mysqli_real_escape_string($conn, $id));
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
        >Salva i dati della posizione</button>
        <input type="hidden" name="id2" id="id2" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo htmlspecialchars($id);}?>">
	</form>
</body>
</html>