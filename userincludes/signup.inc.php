<?php

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];
    $role = $_POST["role"];

    $validOptions = array('administrator', 'SD', 'ITSD', 'hybrid');

    if (!in_array($role, $validOptions)) {
        header("Location: ../user/signup.php?error=invalidrole");
        exit();
    }

    require_once '../db/dbh.inc.php';
    require_once 'userfunctions.inc.php';

    if (emptyInputSignup($firstname, $lastname, $email, $pwd, $pwdRepeat) !== false) {
        header("Location: ../user/signup.php?error=emptyfields");
        exit();
    }
    if (invalidFirstname($firstname) !== false) {
        header("Location: ../user/signup.php?error=invalidfirstname");
        exit();
    }
    if (invalidLastname($lastname) !== false) {
        header("Location: ../user/signup.php?error=invalidlastname");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("Location: ../user/signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("Location: ../user/signup.php?error=nopasswordmatch");
        exit();
    }

    if (emailExists($conn, $email) !== false) {
        header("Location: ../user/login.php?error=emailexists");
        exit();
    }

    createUser($conn, $firstname, $lastname, $email, $pwd, $role);
} else {
    header("Location: ../user/signup.php");
}
