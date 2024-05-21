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
    $sql = "SELECT client.clientFirstname, client.clientLastname, client.clientEmail, client.clientPhoneNumber, client.companyName, client.companyAddress, assignment.assignmentName 
            FROM client 
            LEFT JOIN assignment ON client.clientId = assignment.clientId 
            WHERE client.clientId = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Your Company');
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add some text
        $html = '<h1>Invoice</h1>
                 <p><strong>Client Name:</strong> ' . $row['clientFirstname'] . ' ' . $row['clientLastname'] . '</p>
                 <p><strong>Email:</strong> ' . $row['clientEmail'] . '</p>
                 <p><strong>Phone Number:</strong> ' . $row['clientPhoneNumber'] . '</p>
                 <p><strong>Company Name:</strong> ' . $row['companyName'] . '</p>
                 <p><strong>Company Address:</strong> ' . $row['companyAddress'] . '</p>
                 <p><strong>Assignment:</strong> ' . $row['assignmentName'] . '</p>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Set headers for the PDF output
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="invoice.pdf"');
        header('Cache-Control: max-age=0');
        
        // Output the PDF content
        $pdf->Output('invoice.pdf', 'I');
    } else {
        echo "No client found";
    }
}
?>