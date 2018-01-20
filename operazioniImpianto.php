<?php
	require 'config.php';
    require 'constants.php';
    $conn = '';
	session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $query = sprintf("SELECT * FROM credenziale where email='".$email."' and password='".$password."'");
    if($conn === '') {
    	$conn = new mysqli($servername, $user, $pass, $database);
	}
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
	<form class="form"  action="operazioniImpianto.php" method="post">
    	<br />
    	<span class="visClient">Registrare un nuovo impianto</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID proprietario</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Proprietario" id="idproprietario" name="idproprietario" maxlength="11" value="<?php $id=$_POST['idproprietario']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
            	<tr>
                	<td><span class="filtra2">Nome impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome impianto" id="nomeimpianto" name="nomeimpianto" maxlength="50" value="<?php $nome=$_POST['nomeimpianto']; if(isset($nome)===true){echo $nome;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">Tipo</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Tipo" id="tipo" name="tipo" maxlength="50" value="<?php $tipo=$_POST['tipo']; if(isset($tipo)===true){echo $tipo;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
                  <tr>
                    	<td><span class="filtra2">Città</span></td>
                        <td> <input class="inputfiltro2" type="text" placeholder="Città" id="citta" name="citta" maxlength="50" value="<?php $citta=$_POST['citta']; if(isset($citta)===true){echo $citta;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere"  required/></td>
                  </tr>
                  <tr>
                    	<td><span class="filtra2">Indirizzo</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="Indirizzo" id="indirizzo" name="indirizzo" maxlength="50" value="<?php $indirizzo=$_POST['indirizzo']; if(isset($indirizzo)===true){echo $indirizzo;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                  </tr>
                  <tr>
                    	<td><span class="filtra2">N°Civico</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="N°Civico" id="numcivico" name="numcivico" maxlength="50" value="<?php $numcivico=$_POST['numcivico']; if(isset($numcivico)===true){echo $numcivico;}?>" pattern="[a-zA-Z0-9]+{0,50}"title="Deve essere composta da lettere e/o numeri" required/></td>
                  </tr>
              </tbody>
          </table>
        </div>
        
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                    <tr>
                    	<td><span class="filtra2">Provincia</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="Provincia" id="provincia" name="provincia" maxlength="2" value="<?php $provincia=$_POST['provincia']; if(isset($provincia)===true){echo $provincia;}?>" pattern= "[A-Za-z]{0,2}" title="Deve contenere 2 lettere" required/></td>
                    </tr>
                    <tr>
                    	<td><span class="filtra2">CAP</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="CAP" id="cap" name="cap" maxlength="5" value="<?php $cap=$_POST['cap']; if(isset($cap)===true){echo $cap;}?>" pattern= "[0-9]{0,5}" title="Deve essere composto da soli 5 numeri" required/></td>
                  	</tr>
                    <tr>
                    	<td><span class="filtra2">Descrizione</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Descrizione" id="descrizione" name="descrizione" maxlength="100" value="<?php $descrizione=$_POST['descrizione']; if(isset($descrizione)===true){echo $descrizione;}?>"/></td>
                  	</tr>
                </tbody>
            </table>
        </div>
        <br /><br /><br /><br /><br /><br /><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['aggiungere'])===true){
            	$idcliente = $_POST['idproprietario'];
            	$query=sprintf("SELECT * from utente inner join credenziale on id=utente WHERE permesso='u' and id=".$idcliente);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
            	if($result->num_rows === 0){
                	$str = '<span class="filtra">Non è presente nessun cliente con ID: '.$idcliente.'</span>';
                    echo $str;
                } else {
                	$idproprietario = $_POST['idproprietario'];
                    $nomeimpianto= $_POST['nomeimpianto'];
                    $tipo= $_POST['tipo'];
                    $citta=$_POST['citta'];
                    $indirizzo=$_POST['indirizzo'];
                    $numcivico= $_POST['numcivico'];
                    $provincia= $_POST['provincia'];
                    $cap= $_POST['cap'];
                    $descrizione= $_POST['descrizione'];
                	$query=sprintf('insert into impianto (proprietario, nomeimpianto, citta, indirizzo, numcivico, provincia, cap, descrizione, tipo) values ('.$idproprietario.",'".$nomeimpianto."','".$citta."','".$indirizzo."','".$numcivico."','".$provincia."','".$cap."','".$descrizione."','".$tipo."')");
                	$result = $conn->query($query);
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
    	<button class="buttfiltro" name="aggiungere" value="aggiungere" type="submit" id="aggiungere">Registra impianto</button>
	</form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniImpianto.php" method="post">
    	<br />
    	<span class="visClient">Rimuovere un impianto</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID impianto" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
        <br /><br/><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['rimuovere'])===true){
            	$id = $_POST['id'];
                $query=sprintf('SELECT * FROM impianto WHERE id='.$id);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result->num_rows === 1){
                	$query=sprintf('DELETE FROM impianto WHERE id='.$id);
                    $result = $conn->query($query);
                    if(!($result === false) === true) {
                        $str = '<span class="filtra">Impianto rimosso con successo</span>';
                        echo $str;
                    } else {
                    	$str = '<span class="filtra">Impianto non rimosso, si è verifica un problema</span>';
                        echo $str;
                    }
                } else {
                	$str = '<span class="filtra">Impianto non rimosso, nessun impianto ha ID: '.$id.'</span>';
                    echo $str;
                }
            }
        ?>
    	<button class="buttfiltro" name="rimuovere" value="rimuovere" type="submit" id="rimuovere">Rimuovi impianto</button>
    </form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniImpianto.php" method="post">
    	<br />
    	<span class="visClient">Modificare i dati dell'impianto</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Impianto" id="id2" name="id2" maxlength="11" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
    	<button class="buttfiltro" name="recuperare" value="recuperare" type="submit" id="recuperare">Recupera i dati dell'impianto</button>
    </form>
    <br /><br />
	<form class="form"  action="operazioniImpianto.php" method="post">
    	<br />
        <?php
        	require 'config.php';
            
            if(isset($_POST['recuperare'])===true){
            	$id = $_POST['id2'];
                $query=sprintf('SELECT * FROM impianto WHERE id='.$id);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result->num_rows === 1){
                	$str = '<span class="filtra">Recuperati i dati dell'."'".'impianto con ID: '.$id.'</span>';
                    echo $str;
                } else {
                	$str = '<span class="filtra">Non è presente nessun impianto con ID: '.$id.'</span>';
                    echo $str;
                }
            }
        ?>
        <br /><br />
                <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID proprietario</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Proprietario" id="idproprietario2" name="idproprietario2" maxlength="11" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[DIECI];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$idproprietario=$_POST['idproprietario2'];
                            		if(isset($idproprietario)===true){
                            			echo $idproprietario;
                           	 		}
                                }}
                       		?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
            	<tr>
                	<td><span class="filtra2">Nome impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome impianto" id="nomeimpianto2" name="nomeimpianto2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[DUE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$nomeimpianto=$_POST['nomeimpianto2'];
                            		if(isset($nomeimpianto)===true){
                            			echo $nomeimpianto;
                           	 		}
                                }}
                       		?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">Tipo</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Tipo" id="tipo2" name="tipo2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[NOVE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$tipo=$_POST['tipo2'];
                            		if(isset($tipo)===true){
                            			echo $tipo;
                           	 		}
                                }}
                       		?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
                  <tr>
                    	<td><span class="filtra2">Città</span></td>
                        <td> <input class="inputfiltro2" type="text" placeholder="Città" id="citta2" name="citta2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[TRE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$citta=$_POST['citta2'];
                            		if(isset($citta)===true){
                            			echo $citta;
                           	 		}
                                }}
                       		?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere"  required/></td>
                  </tr>
                  <tr>
                    	<td><span class="filtra2">Indirizzo</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="Indirizzo" id="indirizzo2" name="indirizzo2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[QUATTRO];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$indirizzo=$_POST['indirizzo2'];
                            		if(isset($indirizzo)===true){
                            			echo $indirizzo;
                           	 		}
                                }}
                       		?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                  </tr>
                  <tr>
                    	<td><span class="filtra2">N°Civico</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="N°Civico" id="numcivico2" name="numcivico2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[CINQUE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$numcivico=$_POST['numcivico2'];
                            		if(isset($numcivico)===true){
                            			echo $numcivico;
                           	 		}
                                }}
                       		?>" pattern="[a-zA-Z0-9]+{0,50}"title="Deve essere composta da lettere e/o numeri" required/></td>
                  </tr>
              </tbody>
          </table>
        </div>
        
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                    <tr>
                    	<td><span class="filtra2">Provincia</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="Provincia" id="provincia2" name="provincia2" maxlength="2" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[SEI];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$provincia=$_POST['provincia2'];
                            		if(isset($provincia)===true){
                            			echo $provincia;
                           	 		}
                                }}
                       		?>" pattern= "[A-Za-z]{0,2}" title="Deve contenere 2 lettere" required/></td>
                    </tr>
                    <tr>
                    	<td><span class="filtra2">CAP</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="CAP" id="cap2" name="cap2" maxlength="5" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[SETTE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$cap=$_POST['cap2'];
                            		if(isset($cap)===true){
                            			echo $cap;
                           	 		}
                                }}
                       		?>" pattern= "[0-9]{0,5}" title="Deve essere composto da soli 5 numeri" required/></td>
                  	</tr>
                    <tr>
                    	<td><span class="filtra2">Descrizione</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Descrizione" id="descrizione2" name="descrizione2" maxlength="100" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id WHERE impianto.id='.$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[OTTO];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$descrizione=$_POST['descrizione2'];
                            		if(isset($descrizione)===true){
                            			echo $descrizione;
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
                $idproprietario = $_POST['idproprietario2'];
                $nomeimpianto= $_POST['nomeimpianto2'];
                $tipo= $_POST['tipo2'];
                $citta=$_POST['citta2'];
                $indirizzo=$_POST['indirizzo2'];
                $numcivico= $_POST['numcivico2'];
                $provincia= $_POST['provincia2'];
                $cap= $_POST['cap2'];
                $descrizione= $_POST['descrizione2'];
                
            	$query=sprintf("UPDATE impianto SET proprietario='".$idproprietario."', nomeimpianto='".$nomeimpianto."', citta='".$citta."', indirizzo='".$indirizzo."', numcivico='".$numcivico."', provincia='".$provincia."', cap='".$cap."', descrizione='".$descrizione."', tipo='".$tipo."' WHERE id=".$_POST['id2']);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
				if($result === false) {
                	$str = '<span class="filtra">Impossibile salvare, controllare le modifiche effettuate</span>';
                    echo $str;
                } else {
                	$str = '<span class="filtra">Modifiche salvate con successo</span>';
                    echo $str;
                }
        	}
        ?>
       	<br /><br />
    	<button class="buttfiltro" name="salvare" value="salvare" type="submit" id="salvare" 
        	<?php 
           		require 'config.php';
                $conn = '';
        		$id=$_POST['id2']; 
                if(isset($id)===false){
                	echo ' disabled ';
                }
                $query=sprintf('SELECT * FROM impianto WHERE id='.$id);
                if($conn === '') {
                    $conn = new mysqli($servername, $user, $pass, $database);
                }
                $result = $conn->query($query);
                if($result->num_rows !== 1){
                	echo ' disabled ';
                }
        	?> 
        >Salva i dati dell'impianto</button>
        <input type="hidden" name="id2" id="id2" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo $id;}?>">
	</form>
</body>
</html>