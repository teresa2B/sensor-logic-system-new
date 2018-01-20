<?php
class QueryRegistrazioneUtente{
	function regut($email,$psw, $id, $result, $send, $cf){
    				require 'config.php';
                    require 'constants.php';
                    $conn = new mysqli($servername, $user, $pass, $database);
    				$query = sprintf("insert into credenziale (email, password, permesso, utente) values ('".$email."','".$psw."','t',".$id.')');
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
                    	$query = sprintf("delete from utente where cf='".$cf."'");
                        $conn->query($query);
                    	$str = '<span class="filtra">Registrazione non riuscita</span>';
                        echo $str;
                    }
    }
}