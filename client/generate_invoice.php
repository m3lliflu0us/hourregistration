<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

$currentPage = 'invoice';

include("../db/dbh.inc.php");
require('../fpdf186/fpdf.php');

// Get assignmentId from POST data
$assignmentId = $_POST['assignmentId'];

// Query to get data
$query = "
SELECT a.activityId, a.totalTime, u.userFirstname, u.userLastname, c.clientFirstname, c.clientLastname, c.companyName, c.companyAddress, asgn.assignmentName,
    (SELECT SUM(a.totalTime)
          FROM activity a
          WHERE a.clockedIn = 0 AND a.assignmentId = $assignmentId
    ) AS total
          FROM activity a
          JOIN user u ON a.userId = u.userId
          JOIN assignment asgn ON a.assignmentId = asgn.assignmentId
          JOIN client c ON asgn.clientId = c.clientId
          WHERE a.clockedIn = 0 AND a.assignmentId = $assignmentId;"; 

$result = $conn->query($query);

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetAutoPageBreak(False);
$pdf->SetMargins(0, 0, 0);

$var_id_facture = $assignmentId;

// Generate the PDF
$pdf->AddPage();

// Logo
$pdf->Image('../logo-test.png', 10, 10, 80, 55);

// Page number
$pdf->SetXY(120, 5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(160, 8, '1/1', 0, 0, 'R');

$num_fact = "FACTUUR 2024-0001"; 
$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(192);
$pdf->Rect(120, 15, 85, 8, "DF");
$pdf->SetXY(120, 15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(85, 8, $num_fact, 0, 0, 'C');

$date_fact = date('d/m/Y'); 
$pdf->SetFont('Arial', '', 11);
$pdf->SetXY(122, 30);
$pdf->Cell(60, 8, "Roermond, Limburg " . $date_fact, 0, 0, '');

$observations = "No observations"; 
$pdf->SetFont('Arial', 'BU', 10);
$pdf->SetXY(5, 75);
$pdf->Cell($pdf->GetStringWidth("Observations"), 0, "Observations", 0, "L");
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(5, 78);
$pdf->MultiCell(190, 4, $observations, 0, "L");

if ($row = $result->fetch_assoc()) {
    $client_name = $row['clientFirstname'] . ' ' . $row['clientLastname'];
    $company_name = $row['companyName'];
    $company_address = $row['companyAddress'];
} else {
    $client_name = $company_name = $company_address = "N/A";
}

$pdf->SetFont('Arial', 'B', 11);
$x = 110;
$y = 50;
$pdf->SetXY($x, $y); 
$pdf->Cell(100, 8, $client_name, 0, 0, '');
$y += 4;
$pdf->SetXY($x, $y);
$pdf->Cell(100, 8, $company_name, 0, 0, '');
$y += 4;
$pdf->SetXY($x, $y);
$pdf->Cell(100, 8, $company_address, 0, 0, '');

// Articles table header
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(255, 255, 255); // Set the border color to white
$pdf->Rect(5, 95, 200, 118, "D");
$pdf->Line(5, 105, 205, 105);
$pdf->Line(145, 95, 145, 213);
$pdf->Line(158, 95, 158, 213);
$pdf->Line(176, 95, 176, 213);
$pdf->Line(187, 95, 187, 213);

// Add black line under "Formulering" header
$pdf->SetDrawColor(0, 0, 0); // Set the border color to black
$pdf->Line(5, 103, 205, 103);
$pdf->Line(5, 142, 205, 142);

$pdf->SetXY(1, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 8, "Omschrijving", 0, 0, 'C');
$pdf->SetXY(105, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 8, "Aantal", 0, 0, 'C');
$pdf->SetXY(135, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 8, "Stukprijs", 0, 0, 'C');
$pdf->SetXY(177, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 8, "Totaal", 0, 0, 'C');
$pdf->SetXY(190, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 8, "Btw", 0, 0, 'C');

$totaal = 0;
$pdf->SetFont('Arial', '', 8);
$y = 97;
$result->data_seek(0); 
while ($row = $result->fetch_assoc()) {
    $activityId = $row['activityId'];
    $totalTime = $row['totalTime'];
    $userName = $row['userFirstname'] . ' ' . $row['userLastname'];
    $clientName = $row['clientFirstname'] . ' ' . $row['clientLastname'];
    $companyName = $row['companyName'];
    $assignmentName = $row['assignmentName'];
    
    $totalHours = round($totalTime / 3600 / 0.5) * 0.5;
    $TotalMoney = $totalHours * 12.5;
    $totaal += $TotalMoney;
    $TotalMoneyWithBTW = $TotalMoney * 1.21;
    $btw = $TotalMoneyWithBTW - $TotalMoney;

    // Format monetary values
    $formattedTotalMoney = number_format($TotalMoney, 2, ',', '.');
    $formattedTotalMoneyWithBTW = number_format($TotalMoneyWithBTW, 2, ',', '.');

    $pdf->SetXY(7, $y + 9);
    $pdf->Cell(140, 5, $assignmentName, 0, 0, 'L');
    
    $pdf->SetXY(105, $y + 9);
    $pdf->Cell(13, 5, $totalHours, 0, 0, 'R');
    $pdf->SetXY(132, $y + 9);
    $pdf->Cell(18, 5, "12,50", 0, 0, 'R'); 
    $pdf->SetXY(140, $y + 12);
    $pdf->Cell(25, -1, "$", 0, 0, 'R'); 
    $pdf->SetXY(177, $y + 9);
    $pdf->Cell(10, 5, $formattedTotalMoney, 0, 0, 'R'); 
    $pdf->SetXY(187, $y + 9);
    $pdf->Cell(18, 5, "21%", 0, 0, 'R'); 

    $y += 6;
}

// Format and display the total amount
$formattedTotaal = number_format($totaal, 2, ',', '.');
$formattedBTW = number_format($totaal * 0.21, 2, ',', '.');
$totalPrice = number_format($totaal * 1.21, 2, ',', '.');

// Display the BTW and the line
$pdf->SetXY(177, $y + 9);
$pdf->Cell(10, 7, $formattedTotaal, 0, 0, 'R'); 
$pdf->SetXY(140, $y + 9);
$pdf->Cell(25, 7, "$", 0, 0, 'R'); 

// Add the line under the BTW
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(155, $y + 23, 205, $y + 23);

// Display the total price
$pdf->SetXY(177, $y + 17);
$pdf->Cell(10, 5, $formattedBTW, 0, 0, 'R'); 
$pdf->SetXY(140, $y + 17);
$pdf->Cell(25, 5, "$", 0, 0, 'R'); 

$pdf->Output();
?>
