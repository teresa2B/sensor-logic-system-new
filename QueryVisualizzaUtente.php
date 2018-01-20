<?php
class QueryVisualizzaUtente{
	function visualizzaut($query, $id, $nome, $cognome, $email, $citta){
    					require 'constants.php';
    	 				
                        if(!empty($id) === true) {
                        	$query = $query.sprintf(" and id = '%s'",$id);
                        }
                        if(!empty($nome) === true){
                           	$query = $query.sprintf(" and nome = '%s'", $nome);
                        }
                        if(!empty($cognome) === true){
                           	$query = $query.sprintf(" and cognome = '%s'",$cognome);
                        }
                        if(!empty($email) === true){
                           	$query = $query.sprintf(" and email = '%s'", $email);
                        }
                        if(!empty($citta) === true){
                           	$query = $query.sprintf(" and citta = '%s'",$citta);
                        }
                         $query=$query.sprintf(' order by utente.id');
         return $query;
    }
    function tablequery($result){
    for($i=0; $i<$result->num_rows; $i++) {
                        	$row=mysqli_fetch_row($result);
                            $str='';
                        	$str = '<tr>';
                            $str = $str.'<td>'.htmlspecialchars($row[ZERO]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[UNO]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[TRE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[DUE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[TREDICI]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[CINQUE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[SETTE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[OTTO]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[NOVE]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[UNDICI]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[DIECI]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[SEI]).'</td>';
                            $str = $str.'<td>'.htmlspecialchars($row[QUATTRO]).'</td>';
                            $str = $str.'</tr>';
                            echo $str;
                        }
    }
}