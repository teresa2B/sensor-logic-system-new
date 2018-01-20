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
$query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'",mysqli_real_escape_string($conn, $email),mysqli_real_escape_string($conn, $password));
$result = $conn->query($query);
if($result === false || $result->num_rows !== 1){
    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
}
?>
<?php
require 'config.php';

session_start();
$email = $_SESSION['email'];
$impianto = $_SESSION['impianto'];
$idr = $_SESSION['idr'];
$date = $_SESSION['data'];
$ids = $_SESSION['ids'];
$tipo = $_SESSION['tipo'];
$marca = $_SESSION['marca'];
$nomeposizione = $_SESSION['nomeposizione'];
// dichiarare il percorso dei font

//questo file e la cartella font si trovano nella stessa directory
require 'fpdf.php';
ob_end_clean();
ob_start();
include_once 'OperazioniPDF.php';
include_once 'Tablepdf.php';
class PDF extends FPDF
{
// Page header
    function Header()
    {

        // Arial bold 15
        $this->SetFont(ARIAL,B,QUINDICI);
        // Move to the right
        $this->Cell(OTTANTA);
        // Title
        $this->Cell(TRENTA,DIECI,LOGO,ZERO,ZERO,C);
        // Line break
        $this->Ln(VENTI);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(MENOQUINDICI);
        // Arial italic 8
        $this->SetFont(ARIAL,I,OTTO);
        // Page number
        $this->Cell(ZERO,DIECI,'Page '.$this->PageNo().'/{nb}',ZERO,ZERO,C);
    }

// Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(DUECENTE55,ZERO,ZERO);
        $this->SetTextColor(DUECENTO55);
        $this->SetDrawColor(CENTO28,ZERO,ZERO);
        $this->SetLineWidth(PUNTO3);
        $this->SetFont(VUOTO,VUOTO,OTTO);
        // Header
        $count = count($header);
        for($i=0;$i<$count;$i++)
            $this->Cell(VENTIQUATTRO,SETTE,$header[$i],UNO,ZERO,C,true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(DUECENTO24,DUECENTO35,DUECENTO55);
        $this->SetTextColor(ZERO);
        $this->SetFont(VUOTO);
        // Data
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell(VENTIQUATTRO,SEI,$row[ZERO],LR,ZERO,L,$fill);
            $this->Cell(VENTIQUATTRO,SEI,$row[UNO],LR,ZERO,L,$fill);
            $this->Cell(VENTIQUATTRO,SEI,$row[DUE],LR,ZERO,R,$fill);
            $this->Cell(VENTIQUATTRO,SEI,$row[TRE],LR,ZERO,R,$fill);
            $this->Cell(VENTIQUATTRO,SEI,$row[QUATTRO],LR,ZERO,R,$fill);
            $this->Cell(VENTIQUATTRO,SEI,$row[CINQUE],LR,ZERO,R,$fill);
            $this->Cell(VENTIQUATTRO,SEI,$row[SEI],LR,ZERO,R,$fill);
            $this->Cell(VENTIQUATTRO,SEI,$row[SETTE],LR,ZERO,R,$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line

    }
}

$conn = '';
$query = '';

// crea l'istanza del documento
$p = new PDF();
$p->AliasNbPages();

// aggiunge una pagina
$p->AddPage();

// Impostare le caratteristiche del carattere
$p->SetTextColor(0);
$p->SetFont(ARIAL, VUOTO, NOVE);

// Le funzioni per scrivere il testo
$msg='Rilevazioni dell'."'".'impianto '.$impianto;
$p->Write(CINQUE, $msg);
$msg='';

$objmsg=new OperazioniPDF();
$msg = $objmsg->intestazionePdf($date, $idr, $ids, $tipo, $nomeposizione, $marca);

$p->Write(CINQUE, $msg);
$p->Write(CINQUE, "\n\n");
$header = array('ID Rilevazione', 'Data rilevazione', 'Orario rilevazione', 'Valore rilevazione', 'ID Sensore', 'Tipologia sensore', 'Marca sensore', 'Posizione');
if(empty($conn) === true){
   	$conn = new mysqli($servername, $user, $pass, $database);
}
$querypdf= new OperazioniPDF();
if(empty($query) === true){
	$query= $querypdf->queryPdf(mysqli_real_escape_string($conn, $idr), mysqli_real_escape_string($conn, $ids), mysqli_real_escape_string($conn, $tipo), mysqli_real_escape_string($conn, $nomeposizione), mysqli_real_escape_string($conn, $marca), mysqli_real_escape_string($conn, $impianto), mysqli_real_escape_string($conn, $email));
}

$result = $conn->query($query);

$data = array();

$tablepdf= new Tablepdf();
$data= $tablepdf-> table_pdf($query, $date);

$p->FancyTable($header,$data);

$p->output();
ob_end_flush();
?>
