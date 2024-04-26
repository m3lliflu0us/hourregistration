<?php
include("../config.php");
include("../db/dbh.inc.php");
include("../userincludes/userfunctions.inc.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientFirstname = $_POST['clientFirstname'];
    $clientLastname = $_POST['clientLastname'];
    $clientEmail = $_POST['clientEmail'];
    $clientPhoneNumber = $_POST['clientPhoneNumber'];
    $companyName = $_POST['companyName'];
    $companyAddress = $_POST['companyAddress'];

    $stmt = $conn->prepare("INSERT INTO client (clientFirstname, clientLastname, clientEmail, clientPhoneNumber, companyName, companyAddress) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", $clientFirstname, $clientLastname, $clientEmail, $clientPhoneNumber, $companyName, $companyAddress);

    if ($stmt->execute()) {
        header("location: index.php?succes=clientregistered");
    } else {
        echo "ERROR: Could not execute query: $sql. " . mysqli_error($conn);
    }
}
