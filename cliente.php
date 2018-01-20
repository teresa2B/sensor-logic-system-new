<?php
	require 'config.php';
    $conn = '';
	session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if(empty($conn) === true){
    	$conn = new mysqli($servername, $user, $pass, $database);
    }
    $query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'",mysqli_real_escape_string($conn, $email),mysqli_real_escape_string($conn, $password));

    $result = $conn->query($query);
    if($result === false || $result->num_rows !== 1){
    	    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
    }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SensorLogicSystem</title>
<meta name="viewport" content="width=320">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="adminDesktop.css" media="only screen and (min-width: 401px)" rel="stylesheet" type="text/css">
<link href="adminMobile.css" media="only screen and (max-width: 400px)" rel="stylesheet" type="text/css">
<link href="clienteDesktop.css" media="only screen and (min-width: 401px)" rel="stylesheet" type="text/css">
<link href="clienteMobile.css" media="only screen and (max-width: 400px)" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="wrapper">
		<div class="navbar" style="border: 0;">
        	<br />
        	<span class="logo">Sensor Logic System</span>
			<br />
			<div class="menu_section">
                <br />
                <div class="styled-select blue semi-square">
                    <select name="impianto" id="impianto" onchange="setURL('http://sensorlogicsystemlogin.altervista.org/dashboardClienti.php')" required>
                    <?php
                    	session_start();
                        $conn = '';
                        require 'config.php';
                        if(empty($conn) === true){
    						$conn = new mysqli($servername, $user, $pass, $database);
    					}
                        
                    	$email=$_SESSION['email'];
                        $query=sprintf("SELECT nomeimpianto from credenziale inner join utente on credenziale.utente=utente.id inner join impianto on utente.id=impianto.proprietario where email='%s' order by nomeimpianto",mysqli_real_escape_string($conn, $email));
                        $result=$conn->query($query);
                        $count=$result->num_rows;
                        if($count===0){
                        	$str = '<option class="option"> Nessun impianto registrato</option>';
                            echo $str;
                        }else {
                          for($i=0; $i<$count; $i++){
                              $row=mysqli_fetch_row($result);
                              $str = '<option class="option">'.htmlspecialchars($row[0]).'</option>';
                              echo $str;
                          }
                        }
                    ?>
                    </select>
                </div>
                <br />
                <button type= "button" class="home" onclick="setURL('http://sensorlogicsystemlogin.altervista.org/dashboardClienti.php')">Home</button>
                <div class="dropdown">
  					<button onclick="showDropdownRilevazioni()" class="menu" >Rilevazioni</button>
  					<div id="rilevazioni" class="dropdown-content">
   						 <button type= "button" class="home" onclick="setURL('http://sensorlogicsystemlogin.altervista.org/visualizzaRilevazioni.php')">Visualizzare rilevazioni</button>
    					 <button type= "button" class="home" onclick="setURL('http://sensorlogicsystemlogin.altervista.org/rimuovereRilevazioni.php')">Rimuovere rilevazioni</button>
  					</div>
				</div>
                <br />
                <button type= "button" class="home" onclick="setURL('http://sensorlogicsystemlogin.altervista.org/supporto.php')">Supporto</button>
                <button type= "button" class="home" onclick="setURL('http://sensorlogicsystemlogin.altervista.org/profilo.php')">Profilo</button>
                <a href="logout.php"><button type= "button" class="home">Log-out</button></a>
			</div>
        </div>
        <iframe id="iframe" class="statistiche" src="dashboardClienti.php" name="targetframe" allowTransparency="true" frameborder="0"></iframe>
    </div>

<script>
function setURL(url){
	var e = document.getElementById("impianto");
	var strUser = e.options[e.selectedIndex].value;
    url = url+"?impianto="+strUser;
    document.getElementById('iframe').src = url;
}

function getValueSelect(){
	var e = document.getElementById("ddlViewBy");
	var strUser = e.options[e.selectedIndex].value;
}
</script>

<script type="text/javascript">

    function showDropdownRilevazioni() {
    	document.getElementById("rilevazioni").classList.toggle("show");
	}
  	
	window.onclick = function(event) {
  	if (!event.target.matches('.menu')) {

    	var dropdowns = document.getElementsByClassName("dropdown-content");
    	var i;
    	for (i = 0; i < dropdowns.length; i++) {
     		var openDropdown = dropdowns[i];
      		if (openDropdown.classList.contains('show')) {
        		openDropdown.classList.remove('show');
      		}
    	}
  	 }
	}
</script>
</body>
</html>