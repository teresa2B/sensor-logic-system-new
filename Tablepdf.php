<?php
class Tablepdf{

	function table_pdf($query, $date){
   	require 'config.php';
    require 'constants.php';
	$conn = new mysqli($servername, $user, $pass, $database);
    	$result = $conn->query($query);

		$data = array();
		for($i=0; $i<$result->num_rows; $i++) {
			$row=mysqli_fetch_row($result);
              if(empty($date)===false){
                  $data1=substr($date,ZERO,QUATTRO).substr($date,CINQUE,DUE).substr($date,OTTO,DUE);
                  $data2=substr($row[UNO],ZERO,QUATTRO).substr($row[UNO],QUATTRO,DUE).substr($row[UNO],SEI,DUE);
                  if($data1===$data2){
                      $data[$i] = array($row[ZERO], substr($row[UNO],ZERO,QUATTRO).'-'.substr($row[UNO],QUATTRO,DUE).'-'.substr($row[UNO],SEI,DUE), substr($row[UNO],OTTO,DUE).':'.substr($row[UNO],DIECI,DUE), substr($row[UNO],DODICI), $row[DUE], $row[TRE], $row[QUATTRO], $row[CINQUE]);
                  }
              } else {
                  $data[$i] = array($row[ZERO], substr($row[UNO],ZERO,QUATTRO).'-'.substr($row[UNO],QUATTRO,DUE).'-'.substr($row[UNO],SEI,DUE), substr($row[UNO],OTTO,DUE).':'.substr($row[UNO],DIECI,DUE), substr($row[UNO],DODICI), $row[DUE], $row[TRE], $row[QUATTRO], $row[CINQUE]);
              }
      }return $data;
    }
}