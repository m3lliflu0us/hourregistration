<?php
   
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

include("../db/dbh.inc.php");
include("../config.php");
include("../userincludes/userfunctions.inc.php");

require_once('tcpdf_include.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['clientId'];

    // Fetch the client and assignment data from the database
    // ...

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('maso');
    $pdf->SetAuthor('Your Company');
    $pdf->SetTitle('Simple PDF');
    $pdf->SetSubject('TCPDF Tutorial');
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 12);
    
    // Add some text
    $pdf->Write(0, 'Hello, this is a simple PDF!', '', 0, 'L', true, 0, false, false, 0);

    // Output the PDF
    $pdf->Output('invoice.pdf', 'I');
}
?>
