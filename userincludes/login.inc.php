<?php

if (isset($_POST["submit"])) {

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    require_once '../db/dbh.inc.php';
    require_once 'userfunctions.inc.php';

    if (emptyInputLogin($email, $pwd) !== false) {
        header("location: ../user/login.php?error=emptyfields");
        exit();
    }

    loginUser($conn, $email, $pwd);
} else {
    header("location: ../user/login.php");

    exit();
}
