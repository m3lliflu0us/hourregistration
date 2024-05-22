<?php
include("../config.php");
include("../db/dbh.inc.php");
include("../userincludes/userfunctions.inc.php");

session_start();

$inputText = $_POST['searchAssignment'] ?? '';

$sql = "SELECT assignment.*, client.clientId FROM assignment INNER JOIN client ON assignment.clientId = client.clientId WHERE assignment.assignmentName LIKE ? OR assignment.assignmentId LIKE ? OR client.clientId LIKE ?";
$stmt = $conn->prepare($sql);
$param = "%{$inputText}%";
$stmt->bind_param("sss", $param, $param, $param);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
}
