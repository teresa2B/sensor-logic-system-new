<?php
	require 'config.php';
    $conn = '';
	session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if($conn === '') {
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
</head>

<body>
	<div class="wrapper">
		<div class="navbar" style="border: 0;">
        	<br />
        	<span class="logo">Sensor Logic System</span>
			<br />
			<div class="menu_section">
			<br />
				<button type= "button" class="home" autofocus><a class="home1" href="dashboard.php" target="targetframe">Home</a></button>
                <div class="dropdown">
  					<button onclick="showDropdownImpianti()" class="menu" >Impianti</button>
  					<div id="impianti" class="dropdown-content">
   						<a href="visualizzaImpianti.php" target="targetframe">Visualizzare impianti</a>
    					<a href="operazioniImpianto.php" target="targetframe">Registrare, Rimuovere, Modificare impianto</a>
  					</div>
				</div>
                <div class="dropdown">
  					<button onclick="showDropdownPosizioni()" class="menu" >Posizioni </button>
  					<div id="posizioni" class="dropdown-content">
    					<a href="visualizzaPosizioni.php" target="targetframe">Visualizza posizioni</a>
    					<a href="operazioniPosizione.php" target="targetframe">Registrare, Rimuovere, Modificare Posizione</a>
  					</div>
				</div>
                <div class="dropdown">
  					<button onclick="showDropdownSensori()" class="menu" >Sensori</button>
  					<div id="sensori" class="dropdown-content">
    					<a href="visualizzaSensori.php" target="targetframe">Visualizza sensori</a>
    					<a href="operazioniSensore.php" target="targetframe">Registrare, Rimuovere, Modificare sensore</a>
  					</div>
				</div>
                <br />
                <a href="profilo.php" target="targetframe"><button type= "button" class="home">Profilo</button></a>
                <a href="logout.php"><button type= "button" class="home">Log-out</button></a>
			</div>
        </div>
        <iframe class="statistiche" src="dashboard.php" name="targetframe" allowTransparency="true" frameborder="0"></iframe>
	</div>
 
<script type="text/javascript">    
    function showDropdownImpianti() {
    	document.getElementById("impianti").classList.toggle("show");
        document.getElementById("posizioni").classList.remove("show");
        document.getElementById("sensori").classList.remove("show");
	}
    
    function showDropdownPosizioni() {
    	document.getElementById("posizioni").classList.toggle("show");
        document.getElementById("impianti").classList.remove("show");
        document.getElementById("sensori").classList.remove("show");
	}
    function showDropdownSensori() {
    	document.getElementById("sensori").classList.toggle("show");
        document.getElementById("impianti").classList.remove("show");
        document.getElementById("posizioni").classList.remove("show");
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