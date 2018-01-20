<?php
class QueryModificaUtente{
	function modificaut($cf, $cognome, $nome, $sesso, $telefono, $datadinascita, $citta, $indirizzo, $numcivico,$provincia, $cap, $email ){
    require 'config.php';
    
       $query=sprintf("UPDATE utente SET cf='".$cf."', cognome='".$cognome."', nome='".$nome."', sesso='".$sesso."', telefono='".$telefono."', datadinascita='".$datadinascita."', citta='".$citta."', indirizzo='".$indirizzo."', numcivico='".$numcivico."', provincia='".$provincia."', cap='".$cap."' WHERE id=".$_POST['id2']);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                $query=sprintf("UPDATE credenziale SET email='".$email."' WHERE utente=".$_POST['id2']);
                $result2 = $conn->query($query);
				if($result === false || $result2 === false) {
                	$str =  '<span class="filtra">Impossibile salvare, controllare le modifiche effettuate</span>';
                    echo $str;
                } else {
                	$str = '<span class="filtra">Modifiche salvate con successo</span>';
                    echo $str;
                }
	}
}