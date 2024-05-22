<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
  }
  
$currentPage = 'invoice';


include("../db/dbh.inc.php");

require('../fpdf186/fpdf.php');



// Query to get data
$query = "SELECT a.activityId, a.totalTime, u.userFirstname, u.userLastname, c.clientFirstname, c.clientLastname, c.companyName, c.companyAddress, asgn.assignmentName
          FROM activity a
          JOIN user u ON a.userId = u.userId
          JOIN assignment asgn ON a.assignmentId = asgn.assignmentId
          JOIN client c ON asgn.clientId = c.clientId
          WHERE a.clockedIn = 0";

$result = $conn->query($query);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->Cell(100, 20, 'Invoice', 1, 0, 'C');
$pdf->Ln(20);

// Column headers
$pdf->Cell(40, 10, 'Activity ID', 1);
$pdf->Cell(40, 10, 'Total Time', 1);
$pdf->Cell(40, 10, 'User Name', 1);
$pdf->Cell(40, 10, 'Client Name', 1);
$pdf->Cell(40, 10, 'Company Name', 1);
$pdf->Ln();

// Data
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['activityId'], 1);
    $pdf->Cell(40, 10, $row['totalTime'], 1);
    $pdf->Cell(40, 10, $row['userFirstname'] . ' ' . $row['userLastname'], 1);
    $pdf->Cell(40, 10, $row['clientFirstname'] . ' ' . $row['clientLastname'], 1);
    $pdf->Cell(40, 10, $row['companyName'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>
