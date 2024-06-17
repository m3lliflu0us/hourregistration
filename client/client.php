<?php
include("../config.php");
include("../db/dbh.inc.php");
include("../userincludes/userfunctions.inc.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$clientFirstname = mysqli_real_escape_string($conn, $_POST['clientFirstname']);
$clientLastname = mysqli_real_escape_string($conn, $_POST['clientLastname']);
$clientEmail = mysqli_real_escape_string($conn, $_POST['clientEmail']);
$clientPhoneNumber = mysqli_real_escape_string($conn, $_POST['clientPhoneNumber']);
$companyName = mysqli_real_escape_string($conn, $_POST['companyName']);
$companyAddress = mysqli_real_escape_string($conn, $_POST['companyAddress']);

$stmt = $conn->prepare("INSERT INTO client (clientFirstname, clientLastname, clientEmail, clientPhoneNumber, companyName, companyAddress) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $clientFirstname, $clientLastname, $clientEmail, $clientPhoneNumber, $companyName, $companyAddress);

if ($stmt->execute()) {
header("location: index.php?success=clientregistered");
exit();
} else {
echo "ERROR: Could not execute query. " . mysqli_stmt_error($stmt);
}
$stmt->close();
$conn->close();
}
