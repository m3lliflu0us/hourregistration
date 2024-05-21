<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: user/login.php");
    exit();
}

$currentPage = 'dashboard';

include("config.php");
include("./db/dbh.inc.php");
include("./userincludes/userfunctions.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Gilde DevOps</title>
    <link rel="stylesheet" href="./dashboard/dashboard.css">
    <link rel="stylesheet" href="./assets/layout.css">
<link rel="stylesheet" href="./assets/navbar.css">
    
</head>

<body>
    <main>
        <?php include("./assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
            </div>
        </div>
    </main>
</body>

</html>