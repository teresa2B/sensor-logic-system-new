<?php
	require 'config.php';
    require 'constants.php';

session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
$conn = '';

if($conn === '') {
    $conn = new mysqli($servername, $user, $pass, $database);
}

    $query = sprintf("SELECT * FROM credenziale where email='".$email."' and password='".$password."'");
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
	<span class="visClient">Profilo</span>
    <br /><br />
 	<?php
    	require 'config.php';
        session_start();
        $email = $_SESSION['email'];
        $query = sprintf("select * from utente inner join credenziale on id=utente where email='".$email."'");
        $conn = '';

        if($conn === '') {
            $conn = new mysqli($servername, $user, $pass, $database);
        }
        $result = $conn->query($query);
        $row='';
        if($result->num_rows === 1) {
           $row = mysqli_fetch_row($result);
        }
    ?>
      <form class="form"  action="profilo.php" method="post">
       <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">Nome</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome" id="nome2" name="nome2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                            	
                                if(isset($_POST['salvare'])===true){
                                	$nome=$_POST['nome2'];
                                   
                            		if(isset($nome)===true){
                            			echo $nome;
                                	}
                                }else{
                                	echo $row[TRE];
                                }
                            	
                       		?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required readonly="readonly"/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">Cognome</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Cognome" id="cognome2" name="cognome2" maxlength="50"
                         value="<?php
                                require 'config.php';
                                
                                if(isset($_POST['salvare'])===true){
                                	$cognome=$_POST['cognome2'];
                            		if(isset($cognome)===true){
                            			echo $cognome;
                                	}
                                }else{
                                	echo $row[DUE];
                                }
                            	
                       		?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required readonly="readonly"/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">CF</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="CF" id="cf2" name="cf2" maxlength="16"
                         value="<?php
                            	require 'config.php';
                                
                                if(isset($_POST['salvare'])===true){
                                	$cf=$_POST['cf2'];
                            		if(isset($cf)===true){
                            			echo $cf;
                                	}
                                }else{
                                	echo $row[UNO];
                                }
                       		?>" pattern= "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" title="Deve essere composto da 16 valori, seguendo il formato del cofice fiscale" required readonly="readonly"/></td>
                </tr>
                <tr>
                	<td><span class="filtra2">Sesso</span></td>
                    <td>
                    	<select readonly="readonly" name="sesso2" id="sesso2" classe="sesso" title="Selezionare il sesso" required>
  							<option value="m"
                            <?php
                            	require 'config.php';
                                
                                if(isset($_POST['salvare'])===true){
                                	$sesso=$_POST['sesso2'];
                            		if(isset($sesso)===true){
                            			if($sesso==='m'){echo 'selected="selected"';}
                                	}
                                }else{
                                	if($row[QUATTRO]==='m'){echo 'selected="selected"';}
                                }
                       		?>>M</option>
  							<option value="f"
                            <?php
                            	require 'config.php';
                                
                                if(isset($_POST['salvare'])===true){
                                	$sesso=$_POST['sesso2'];
                            		if(isset($sesso)===true){
                            			if($sesso==='f'){echo 'selected="selected"';}
                                	}
                                }else{
                                	if($row[QUATTRO]==='f'){echo 'selected="selected"';}
                                }
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
                            	

                                if(isset($_POST['salvare'])===true){
                                	$telefono=$_POST['telefono2'];
                            		if(isset($telefono)===true){
                            			echo $telefono;
                                	}
                                }else{
                                	echo $row[CINQUE];
                                }
                                ?>" pattern= "[0-9]{0,10}" title="Deve essere composto da soli 10 numeri" required/></td>
                  </tr>
                  <tr>
                      <td><span class="filtra2">Email</span></td>
                      <td><input class="inputfiltro2" type="text" placeholder="Email" id="email2" name="email2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                            	

                                if(isset($_POST['salvare'])===true){
                                	$email=$_POST['email2'];
                            		if(isset($email)===true){
                            			echo $email;
                                	}
                                }else{
                                	echo $row[TREDICI];
                                }
                            	?>" pattern= "[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve rispettare il formato: email@dominio.com" required/></td>
                  </tr>
                  <tr>
                      <td><span class="filtra2">Data di nascita</span></td>
                      <td> <input class="inputfiltro2" type="date" placeholder="Data di nascita" id="datadinascita2" name="datadinascita2"
                         value="<?php
                            	require 'config.php';
                            	

                                if(isset($_POST['salvare'])===true){
                                	$datadinascita=$_POST['datadinascita2'];
                            		if(isset($datadinascita)===true){
                            			echo $datadinascita;
                                	}
                                }else{
                                	echo $row[SEI];
                                }
                       		?>" title="Deve contenere una data valida" required readonly="readonly"/></td>
                  </tr>
                  <tr>
                      <td><span class="filtra2">CAP</span></td>
                      <td>  <input class="inputfiltro2" type="text" placeholder="CAP" id="cap2" name="cap2" maxlength="5"
                         value="<?php
                            	require 'config.php';
                            	

                                if(isset($_POST['salvare'])===true){
                                	$cap=$_POST['cap2'];
                            		if(isset($cap)===true){
                            			echo $cap;
                                	}
                                }else{
                                	echo $row[UNDICI];
                                }
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
                            	

                                if(isset($_POST['salvare'])===true){
                                	$citta=$_POST['citta2'];
                            		if(isset($citta)===true){
                            			echo $citta;
                                	}
                                }else{
                                	echo $row[SETTE];
                                }
                            	?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere"  required/></td>
                    </tr>
                    <tr>
                    	<td><span class="filtra2">Indirizzo</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="indirizzo" id="indirizzo2" name="indirizzo2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                            	

                                if(isset($_POST['salvare'])===true){
                                	$indirizzo=$_POST['indirizzo2'];
                            		if(isset($indirizzo)===true){
                            			echo $indirizzo;
                                	}
                                }else{
                                	echo $row[OTTO];
                                }
                            	?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                    </tr>
                    <tr>
                    	<td><span class="filtra2">N°Civico</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="numcivico" id="numcivico2" name="numcivico2" maxlength="50"
                         value="<?php
                            	require 'config.php';
                            	

                                if(isset($_POST['salvare'])===true){
                                	$numcivico=$_POST['numcivico2'];
                            		if(isset($numcivico)===true){
                            			echo $numcivico;
                                	}
                                }else{
                                	echo $row[NOVE];
                                }
                            	?>" pattern="[a-zA-Z0-9]+{0,50}"title="Deve essere composta da lettere e/o numeri" required/></td>
                    </tr>
                    <tr>
                    	<td><span class="filtra2">Provincia</span></td>
                        <td><input class="inputfiltro2" type="text" placeholder="Provincia" id="provincia2" name="provincia2" maxlength="2"
                         value="<?php
                            	require 'config.php';
                            	

                                if(isset($_POST['salvare'])===true){
                                	$provincia=$_POST['provincia2'];
                            		if(isset($provincia)===true){
                            			echo $provincia;
                                	}
                                }else{
                                	echo $row[DIECI];
                                }
                            	?>" pattern= "[A-Za-z]{0,2}" title="Deve contenere 2 lettere" required/></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['salvare'])===true){
                $telefono= $_POST['telefono2'];
                $citta=$_POST['citta2'];
                $indirizzo=$_POST['indirizzo2'];
                $numcivico= $_POST['numcivico2'];
                $provincia= $_POST['provincia2'];
                $cap= $_POST['cap2'];
                $email= $_POST['email2'];
            	$query=sprintf("UPDATE utente SET telefono='".$telefono."', citta='".$citta."', indirizzo='".$indirizzo."', numcivico='".$numcivico."', provincia='".$provincia."', cap='".$cap."' WHERE id=".$row[0]);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                $query=sprintf("UPDATE credenziale SET email='".$email."' WHERE utente=".$row[0]);
                $result2 = $conn->query($query);
				if($result === false || $result2 === false) {
                    $str = '<span class="filtra">Impossibile salvare, controllare le modifiche effettuate</span>';

                    echo $str;
                } else {
                    $str = '<span class="filtra">Modifiche salvate con successo</span>';

                    echo $str;
                }
        	}
        ?>
       	<br />
    	<button class="buttfiltro" name="salvare" value="salvare" type="submit" id="salvare">Salva i dati</button>
		<br />
    </form>
     <br /><br />
    <hr class="separator">
    <form class="form"  action="profilo.php" method="post">
        <br /> 
      <span class="visClient">Modifica Password</span>
      <br /><br />
    	<span class="filtra2">Password</span>
        <input class="inputfiltro2" type="password" placeholder="Password" id="password" name="password" 
        	value="<?php
             require 'config.php';

             if(isset($_POST['modificare'])===true){
                $password=$_POST['password'];
                if(isset($password)===true){
                   echo $password;
                }}          	
          	?>"
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="30" title="Deve contenere almeno un numero, una lettera maiuscola e minuscola, e minimo 8 caratteri" required>
      
        <span class="filtra2">Conferma password</span>
         <input class="inputfiltro2" type="password" placeholder="Password" id="password2" name="password2" 
              value="<?php
               require 'config.php';

               if(isset($_POST['modificare'])===true){
                  $password=$_POST['password2'];
                  if(isset($password)===true){
                     echo $password;
                  }}          	
              ?>"
          pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="30" title="Deve contenere almeno un numero, una lettera maiuscola e minuscola, e minimo 8 caratteri" required>
  
       <?php
        	if(isset($_POST['modificare'])===true){
              $password=$_POST['password'];
              $password2=$_POST['password2'];
              if($password===$password2){
                  $query= sprintf("UPDATE credenziale SET password='".$password."' where email ='".$email."'");
                  $result=$conn->query($query);
                  if($result===false){
                      $str = '<span class="filtra">Impossibile modificare la password</span>';

                      echo $str;
                  }else{
                      $str = '<span class="filtra">Password modificata</span>';

                      echo $str;
                  }
              }else{
                  $str = '<span class="filtra">Le password inserite non sono uguali</span>';

                  echo $str;
              }
            }
        ?>
        <br /><br />
        <button class="buttfiltro" name="modificare" value="modificare" type="submit" id="modificare">Modifica la password</button>
    	<br />
    </form>
</body>
</html>
