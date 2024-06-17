<?php
define('EURO', chr(128));
session_start();

// Check if the user is logged in
if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

// Include database connection and FPDF library
include("../db/dbh.inc.php");
require('../fpdf186/fpdf.php');

// Check if assignmentId is set in POST request
if (!isset($_POST['assignmentId'])) {
    echo "Assignment ID is missing.";
    exit();
}

$assignmentId = $_POST['assignmentId'];

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("
SELECT a.activityId, a.totalTime, u.userFirstname, u.userLastname, c.clientFirstname, c.clientLastname, c.companyName, c.companyAddress, asgn.assignmentName
FROM activity a
JOIN user u ON a.userId = u.userId
JOIN assignment asgn ON a.assignmentId = asgn.assignmentId
JOIN client c ON asgn.clientId = c.clientId
WHERE a.clockedIn = 0 AND a.assignmentId = ?
");

$stmt->bind_param("i", $assignmentId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    echo "No records found.";
    exit();
}

// Initialize PDF generation
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Set font for the entire document
$pdf->SetFont('Arial', 'B', 14);

// Set up a logo
$pdf->Image('../img/logo.png', 10, 10, -300);

// Move to the right
$pdf->Cell(80);

// Title
$pdf->Cell(30, 10, 'Invoice', 0, 1, 'C');

// Line break
$pdf->Ln(20);

// Invoice contents
$pdf->SetFont('Arial', 'B', 12);

// Header
$pdf->Cell(50, 10, 'Description', 1);
$pdf->Cell(40, 10, 'Qty', 1);
$pdf->Cell(50, 10, 'Unit Price', 1);
$pdf->Cell(50, 10, 'Total', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

// Data from database
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(50, 10, $row['assignmentName'], 1);
    $pdf->Cell(40, 10, '1', 1); // Quantity is hardcoded to 1 for simplicity
    $pdf->Cell(50, 10, number_format($row['totalTime'] / 3600 * 50, 2), 1); // Assuming $50/hr rate
    $pdf->Cell(50, 10, number_format($row['totalTime'] / 3600 * 50, 2), 1); // Total is the same as unit price for 1 qty
    $pdf->Ln();
}

// Sum total
$pdf->Cell(140, 10, 'Total', 1);
$pdf->Cell(50, 10, EURO . number_format($totaal, 2), 1);

// Clean the output buffer to avoid corrupting the PDF
ob_end_clean();

// Set the headers for the PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="invoice_' . $assignmentId . '.pdf"');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

// Output the PDF to the browser
$pdf->Output('I', 'invoice_' . $assignmentId . '.pdf');
