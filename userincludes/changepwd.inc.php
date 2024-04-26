<?php
session_start();
include '../db/dbh.inc.php'; // Include your database configuration file

// Get input from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input from the form
    $oldPwd = isset($_POST['Pwd']) ? $_POST['Pwd'] : '';
    $newPwd = isset($_POST['newPwd']) ? $_POST['newPwd'] : '';
    $confirmNewPwd = isset($_POST['confNewPwd']) ? $_POST['confNewPwd'] : '';
}

// Check if any field is empty
if (empty($oldPwd) || empty($newPwd) || empty($confirmNewPwd)) {
    // Handle the error (e.g., redirect to an error page)
    exit();
}

// Check if new password and confirm new password match
if ($newPwd !== $confirmNewPwd) {
    // Handle the error (e.g., redirect to an error page)
    header("location: ../?error=pwdmismatch");
    exit();
}

// Retrieve the current hashed password from the database
$sql = "SELECT userPwd FROM user WHERE userId = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    // Handle the error (e.g., redirect to an error page)
    exit();
}

$userId = $_SESSION["userId"];
mysqli_stmt_bind_param($stmt, "s", $userId);
mysqli_stmt_execute($stmt);
$resultData = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($resultData)) {
    $pwdHashed = $row["userPwd"];
} else {
    // User does not exist; handle accordingly (e.g., redirect with an error message)
    exit();
}

// Verify the old password
$checkPwd = password_verify($oldPwd, $pwdHashed);

if ($checkPwd === true) {
    // Hash the new password
    $newPwdHashed = password_hash($newPwd, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE user SET userPwd=? WHERE userId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle the error (e.g., redirect to an error page)
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $newPwdHashed, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Password successfully changed
    header("location: ../?error=none");
    exit();
} else {
    // Incorrect old password; handle accordingly (e.g., redirect with an error message)
    header("location: ../?error=pwdwrong");
    exit();
}
