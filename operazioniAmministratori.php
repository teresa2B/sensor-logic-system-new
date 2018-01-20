<?php
    include_once 'Layout.php';
	require 'config.php';
    require 'nocsrf.php';
    require 'constants.php';
	$csrf = new nocsrf();
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
	<form class="form"  action="operazioniAmministratori.php" method="post">
    	<br />
    	<span class="visClient">Registrare un nuovo amministratore</span><br /><br /><br />
        <?php
        $layout = new Layout();
        echo $layout->layoutop(htmlspecialchars($_POST['nome']), htmlspecialchars($_POST['cognome']), htmlspecialchars($_POST['cf']), htmlspecialchars($_POST['sesso']), htmlspecialchars($_POST['telefono']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['datadinascita']));
        echo $layout->layoubot(htmlspecialchars($_POST['cap']), htmlspecialchars($_POST['citta']), htmlspecialchars($_POST['indirizzo']), htmlspecialchars($_POST['numcivico']), htmlspecialchars($_POST['provincia']));
        ?>
        
        <?php
        	require 'config.php';
        	
            if(isset($_POST['aggiungere'])===true){
            	$cf = $_POST['cf'];
                $cognome= $_POST['cognome'];
                $nome= $_POST['nome'];
                $sesso= $_POST['sesso'];
                $telefono= $_POST['telefono'];
                $datadinascita= $_POST['datadinascita'];
                $citta=$_POST['citta'];
                $indirizzo=$_POST['indirizzo'];
                $numcivico= $_POST['numcivico'];
                $provincia= $_POST['provincia'];
                $cap= $_POST['cap'];
                $email = $_POST['email'];
                $today= getdate();
                $dataregistrazione= $today['year'].'-'.$today['mon'].'-'.$today['mday'];
                
            	$query = sprintf("insert into utente (cf, cognome, nome, sesso, telefono, datadinascita, citta, indirizzo, numcivico, provincia, cap, dataregistrazione) values ('".$cf."','".$cognome."','".$nome."','".$sesso."','".$telefono."','".$datadinascita."','".$citta."','".$indirizzo."','".$numcivico."','".$provincia."',".$cap.",'".$dataregistrazione."')");
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result !== false) {
                	$query = sprintf("select id from utente where cf ='".$cf."'");
                	$result = $conn->query($query);
                    $row = mysqli_fetch_row($result);
                    $id= $row[0];
                    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
   					$pass = array();
    				$alphaLength = strlen($alphabet) - 1;
    				for ($i = ZERO; $i < OTTO; $i++) {
       	 				$n = rand(0, $alphaLength);
       					$pass[] = $alphabet[$n];
   					}
   					$psw = implode($pass);
                    $query = sprintf("insert into credenziale (email, password, permesso, utente) values ('".$email."','".$psw."','a',".$id.')');
                    $result = $conn->query($query);
                    if($result !== false) {
                    	$str = '<span class="filtra">Registrazione riuscita</span>';
                        echo $str;
                        $nome_mittente = 'SensorLogicSystem';
                        $mail_mittente = 'sensorlogicsystem@gmail.com';
                        $mail_oggetto = 'Benvenuto/a nella nostra azienda';
                        $mail_headers = 'From: ' .  $nome_mittente . ' <' .  $mail_mittente . '>\r\n';
                        $mail_headers .= 'Reply-To: ' .  $mail_mittente . '\r\n';
                        $mail_corpo = 'Gentile cliente, la ringraziamo per averci scelto. Ecco di seguito le sue credenziali per poter accedere ai suoi servizi. Password: '.$psw;

                        $regexemail = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/';
						$send = false;
                        if (preg_match($regexemail, $email) === 1) {
                        	if($csrf->check(CSRF, $_POST, false, SIZE, true) === true){
                        		$send = mail($email, $mail_oggetto, $mail_corpo, $mail_headers);
                            }
                        }
                        if($send === true){
                        	$str = '<br /><span class="filtra">E-mail inviata al cliente</span>';
                            echo $str;
                        } else {
                        	$str = '<br /><span class="filtra">'."Invio dell'e-mail non riuscito".'</span>';
                            echo $str;
                        }
                    } else {
                    	$query = sprintf("delete from utente where cf='".$_POST['cf']."'");
                        $conn->query($query);
                    	$str = '<span class="filtra">Registrazione non riuscita</span>';
                        echo $str;
                    }
                } else {
                	$str = '<span class="filtra">Registrazione non riuscita</span>';
                    echo $str;
                }
            }
        ?>
   
       	<br /><br /><br />
    	<button class="buttfiltro" name="aggiungere" value="aggiungere" type="submit" id="aggiungere">Registra amministratore</button>
	</form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniAmministratori.php" method="post">
    	<br />
    	<span class="visClient">Rimuovere un amministratore</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
        <br /><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['rimuovere'])===true){
            	$id = $_POST['id'];
                $query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$id." and permesso='a'");
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result->num_rows === 1){
                	$query=sprintf('DELETE FROM utente WHERE id='.$id);
                    $result = $conn->query($query);
                    if(!($result === false) === true) {
                        $str = '<span class="filtra">Amministratore rimosso con successo</span>';
                        echo $str;
                    } else {
                    	$str = '<span class="filtra">Amministratore non rimosso, si è verifica un problema</span>';
                        echo $str;
                    }
                } else {
                	$str = '<span class="filtra">Amministratore non rimosso, nessun amministratore ha ID: '.$id.'</span>';
                    echo $str;
                }
            }
        ?>
    	<button class="buttfiltro" name="rimuovere" value="rimuovere" type="submit" id="rimuovere">Rimuovi amministratore</button>
    </form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniAmministratori.php" method="post">
    	<br />
    	<span class="visClient">Modificare i dati di un amministratore</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID" id="id2" name="id2" maxlength="11" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
    	<button class="buttfiltro" name="recuperare" value="recuperare" type="submit" id="recuperare">Recupera i dati dell'amministratore</button>
    </form>
    <br /><br />
	<form class="form"  action="operazioniAmministratori.php" method="post">
    	<br />
        <?php
        	require 'config.php';
            
            if(isset($_POST['recuperare'])===true){
            	$id = $_POST['id2'];
                $query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$id." and permesso='a'");
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result->num_rows === 1){
                	$str = '<span class="filtra">Recuperati i dati dell'."'".'amministratore con ID: '.$id.'</span>';
                    echo $str;
                } else {
                	$str = '<span class="filtra">Non è presente nessun amministratore con ID: '.$id.'</span>';
                    echo $str;
                }
            }
        ?>
        <br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">Nome</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome" id="nome2" name="nome2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[TRE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$nome=$_POST['nome2'];
                            		if(isset($nome)===true){
                            			echo $nome;
                           	 		}
                                } }
                       		?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">Cognome</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Cognome" id="cognome2" name="cognome2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[DUE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$cognome=$_POST['cognome2'];
                            		if(isset($cognome)===true){
                            			echo $cognome;
                           	 		}
                                }}
                       		?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">CF</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="CF" id="cf2" name="cf2" maxlength="16"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[UNO];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$cf=$_POST['cf2'];
                            		if(isset($cf)===true){
                            			echo $cf;
                           	 		}
                                }}
                       		?>" pattern= "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" title="Deve essere composto da 16 valori, seguendo il formato del cofice fiscale" required/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">Sesso</span></td>
                    <td>
                    	<select name="sesso2" id="sesso2" classe="sesso" title="Selezionare il sesso" required>
  							<option value="m"
                            <?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                                        if($row[QUATTRO]==='m'){echo 'selected="selected"';}
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$sesso=$_POST['sesso2'];
                            		if(isset($sesso)===true){
                            			if($sesso==='m'){echo 'selected="selected"';}
                           	 		}
                                }}
                       		?>>M</option>
  							<option value="f"
                            <?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                                        if($row[QUATTRO]==='f'){echo 'selected="selected"';}
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$sesso=$_POST['sesso2'];
                            		if(isset($sesso)===true){
                            			if($sesso==='f'){echo 'selected="selected"';}
                           	 		}
                                }}
                       		?>>F</option>
                    	</select> 
                	</td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
                  <tr>
                      <td><span class="filtra2">Telefono</span></td>
                      <td> <input class="inputfiltro2" type="text" placeholder="Telefono" id="telefono2" name="telefono2" maxlength="10"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[CINQUE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$telefono=$_POST['telefono2'];
                            		if(isset($telefono)===true){
                            			echo $telefono;
                           	 		}
                                }}
                       		?>" pattern= "[0-9]{0,10}" title="Deve essere composto da soli 10 numeri" required/></td>
                  </tr>
                  <tr>
                      <td><span class="filtra2">Email</span></td>
                      <td><input class="inputfiltro2" type="text" placeholder="Email" id="email2" name="email2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[TREDICI];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$email=$_POST['email2'];
                            		if(isset($email)===true){
                            			echo $email;
                           	 		}
                                }}
                       		?>" pattern= "[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve rispettare il formato: email@dominio.com" required/></td>
                  </tr>                 
                  <tr>
                      <td><span class="filtra2">Data di nascita</span></td>
                      <td> <input class="inputfiltro2" type="date" placeholder="Data di nascita" id="datadinascita2" name="datadinascita2"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[SEI];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$data=$_POST['datadinascita2'];
                            		if(isset($data)===true){
                            			echo $data;
                           	 		}
                                }}
                       		?>" title="Deve contenere una data valida" required/></td>
                  </tr>
                  <tr>
                      <td><span class="filtra2">CAP</span></td>
                      <td>  <input class="inputfiltro2" type="text" placeholder="CAP" id="cap2" name="cap2" maxlength="5"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[UNDICI];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$cap=$_POST['cap2'];
                            		if(isset($cap)===true){
                            			echo $cap;
                           	 		}
                                }}
                       		?>" pattern= "[0-9]{0,5}" title="Deve essere composto da soli 5 numeri" required/></td>
                  </tr>
              </tbody>
          </table>
        </div>
        
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                	<tr>
                    	<td><span class="filtra2">Città</span></td>
                        <td> <input class="inputfiltro2" type="text" placeholder="citta" id="citta2" name="citta2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[SETTE];
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
                        <td><input class="inputfiltro2" type="text" placeholder="indirizzo" id="indirizzo2" name="indirizzo2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[OTTO];
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
                        <td><input class="inputfiltro2" type="text" placeholder="numcivico" id="numcivico2" name="numcivico2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[NOVE];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$numcivico=$_POST['numcivico2'];
                            		if(isset($numcivico)===true){
                            			echo $numcivico;
                           	 		}
                                }}
                       		?>" pattern="[a-zA-Z0-9]+{0,50}"title="Deve essere composta da lettere e/o numeri" required/></td>
                    </tr>
                    <tr>
                    	<td><span class="filtra2">Provincia</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="Provincia" id="provincia2" name="provincia2" maxlength="2"
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$_POST['id2']." and permesso='a'");
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[DIECI];
                                    }
                                } else{if(isset($_POST['salvare'])===true) {
                                	$provincia=$_POST['provincia2'];
                            		if(isset($provincia)===true){
                            			echo $provincia;
                           	 		}
                                }}
                       		?>" pattern= "[A-Za-z]{0,2}" title="Deve contenere 2 lettere" required/></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
        	require 'config.php';
            include_once 'QueryModificaUtente.php';
        	if(isset($_POST['salvare'])===true){
            	$cf = $_POST['cf2'];
                $cognome= $_POST['cognome2'];
                $nome= $_POST['nome2'];
                $sesso= $_POST['sesso2'];
                $telefono= $_POST['telefono2'];
                $datadinascita= $_POST['datadinascita2'];
                $citta=$_POST['citta2'];
                $indirizzo=$_POST['indirizzo2'];
                $numcivico= $_POST['numcivico2'];
                $provincia= $_POST['provincia2'];
                $cap= $_POST['cap2'];
                $email= $_POST['email2'];
            	$modut= new QueryModificaUtente();
                $modut-> modificaut($cf, $cognome, $nome, $sesso, $telefono, $datadinascita, $citta, $indirizzo, $numcivico,$provincia, $cap, $email );
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
                $query=sprintf('SELECT * FROM utente inner join credenziale on id=utente WHERE id='.$id." and permesso='a'");
                if($conn === '') {
                    $conn = new mysqli($servername, $user, $pass, $database);
                }
                $result = $conn->query($query);
                if($result->num_rows !== 1){
                	echo ' disabled ';
                }
        	?> 
        >Salva i dati dell'amministratore</button>
        <input type="hidden" name="id2" id="id2" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo $id;}?>">
	</form>
</body>
</html>
