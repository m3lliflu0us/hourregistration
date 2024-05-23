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
$query = "SELECT a.activityId, a.totalTime, u.userFirstname, u.userLastname, c.clientFirstname, c.clientLastname, c.companyName, c.companyAddress, asgn.assignmentName
          FROM activity a
          JOIN user u ON a.userId = u.userId
          JOIN assignment asgn ON a.assignmentId = asgn.assignmentId
          JOIN client c ON asgn.clientId = c.clientId
          WHERE a.clockedIn = 0 AND a.assignmentId = $assignmentId"; // Filter by assignmentId

$result = $conn->query($query);

// Instantiate the PDF object
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

// Invoice details (hardcoded for this example)
$num_fact = "FACTUUR 2024-0001"; // Replace with dynamic data if available
$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(192);
$pdf->Rect(120, 15, 85, 8, "DF");
$pdf->SetXY(120, 15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(85, 8, $num_fact, 0, 0, 'C');

$date_fact = date('d/m/Y'); // Use current date for invoice date
$pdf->SetFont('Arial', '', 11);
$pdf->SetXY(122, 30);
$pdf->Cell(60, 8, "Roermond, Limburg " . $date_fact, 0, 0, '');

// Observations (hardcoded for this example)
$observations = "No observations"; // Replace with dynamic data if available
$pdf->SetFont('Arial', 'BU', 10);
$pdf->SetXY(5, 75);
$pdf->Cell($pdf->GetStringWidth("Observations"), 0, "Observations", 0, "L");
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(5, 78);
$pdf->MultiCell(190, 4, $observations, 0, "L");

// Client details
if ($row = $result->fetch_assoc()) {
    $client_name = $row['clientFirstname'] . ' ' . $row['clientLastname'];
    $company_name = $row['companyName'];
    $company_address = $row['companyAddress'];
} else {
    $client_name = $company_name = $company_address = "N/A"; // Default values if no data
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
$pdf->SetLineWidth(0.1);
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

$pdf->SetXY(1, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(140, 8, "Formulering", 0, 0, 'C');
$pdf->SetXY(145, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 8, "Aantal", 0, 0, 'C');
$pdf->SetXY(156, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 8, "Excl. BTW", 0, 0, 'C');
$pdf->SetXY(177, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 8, "VAT", 0, 0, 'C');
$pdf->SetXY(185, 96);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 8, "Totaal Bedrag", 0, 0, 'C');

// Articles data
$pdf->SetFont('Arial', '', 8);
$y = 97;
$result->data_seek(0); // Reset the result pointer to the beginning
while ($row = $result->fetch_assoc()) {
    $activityId = $row['activityId'];
    $totalTime = $row['totalTime'];
    $userName = $row['userFirstname'] . ' ' . $row['userLastname'];
    $clientName = $row['clientFirstname'] . ' ' . $row['clientLastname'];
    $companyName = $row['companyName'];
    $assignmentName = $row['assignmentName'];
    
    // Convert totalTime from seconds to hours and round to the nearest half hour
    $totalHours = round($totalTime / 3600 / 0.5) * 0.5;
    $TotalMoney = $totalHours * 2;
    $TotalMoneyWithBTW = $TotalMoney * 1.21;

    $totalHT = $TotalMoney;
    $totalTVA = $TotalMoneyWithBTW - $TotalMoney;
    $totalTTC = $TotalMoneyWithBTW;

    $pdf->SetXY(7, $y + 9);
    $pdf->Cell(140, 5, $assignmentName, 0, 0, 'L');
    $pdf->SetXY(145, $y + 9);
    $pdf->Cell(13, 5, $totalHours, 0, 0, 'R');
    $pdf->SetXY(158, $y + 9);
    $pdf->Cell(18, 5, $TotalMoney, 0, 0, 'R'); // Replace with actual unit price if available
    $pdf->SetXY(177, $y + 9);
    $pdf->Cell(10, 5, "21%", 0, 0, 'R'); // Replace with actual VAT rate if available
    $pdf->SetXY(187, $y + 9);
    $pdf->Cell(18, 5, $TotalMoneyWithBTW, 0, 0, 'R'); // Replace with actual total price if available

    $pdf->Line(5, $y + 14, 205, $y + 14);
    $y += 6;
}



// Totals (example values, replace with actual calculations if available)
$totalHT = 0; // Replace with actual HT total
$totalTVA = 0; // Replace with actual TVA total
$totalTTC = 0; // Replace with actual TTC total

$pdf->SetLineWidth(0.1);
$pdf->Rect(130, 221, 75, 24, "D");
$pdf->Line(147, 221, 147, 245);
$pdf->Line(164, 221, 164, 245);
$pdf->Line(181, 221, 181, 245);
$pdf->Line(130, 227, 205, 227);
$pdf->Line(130, 233, 205, 233);
$pdf->Line(130, 239, 205, 239);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(181, 221);
$pdf->Cell(24, 6, "BTW", 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY(105, 221);
$pdf->Cell(25, 6, "BTW VAT", 0, 0, 'R');
$pdf->SetXY(105, 227);
$pdf->Cell(25, 6, "Totaal Bedrag", 0, 0, 'R');
$pdf->SetXY(105, 233);
$pdf->Cell(25, 6, "Total BTW", 0, 0, 'R');
$pdf->SetXY(105, 239);
$pdf->Cell(25, 6, "incl. BTW", 0, 0, 'R');

$pdf->SetXY(130, 221);
$pdf->Cell(17, 6, "21 %", 0, 0, 'C'); 
$pdf->SetXY(130, 227);
$pdf->Cell(17, 6, number_format($totalHT, 2, ',', ' '), 0, 0, 'R');
$pdf->SetXY(130, 233);
$pdf->Cell(17, 6, number_format($totalTVA, 2, ',', ' '), 0, 0, 'R');
$pdf->SetXY(130, 239);
$pdf->Cell(17, 6, number_format($totalTTC, 2, ',', ' '), 0, 0, 'R');

$pdf->SetXY(147, 227);
$pdf->Cell(17, 6, "", 0, 0, 'R');
$pdf->SetXY(147, 233);
$pdf->Cell(17, 6, "", 0, 0, 'R');
$pdf->SetXY(147, 239);
$pdf->Cell(17, 6, "", 0, 0, 'R');

$pdf->SetXY(164, 227);
$pdf->Cell(17, 6, "", 0, 0, 'R');
$pdf->SetXY(164, 233);
$pdf->Cell(17, 6, "", 0, 0, 'R');
$pdf->SetXY(164, 239);
$pdf->Cell(17, 6, "", 0, 0, 'R');

$pdf->SetXY(181, 227);
$pdf->Cell(24, 6, number_format($totalHT, 2, ',', ' '), 0, 0, 'R');
$pdf->SetXY(181, 233);
$pdf->Cell(24, 6, number_format($totalTVA, 2, ',', ' '), 0, 0, 'R');
$pdf->SetXY(181, 239);
$pdf->Cell(24, 6, number_format($totalTTC, 2, ',', ' '), 0, 0, 'R');

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY(5, 221);

$pdf->Output();
?>
