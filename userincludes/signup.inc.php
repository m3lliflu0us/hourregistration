<?php

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];

    $validOptions = array('administrator', 'SD', 'ITSD', 'hybrid');

    if (!in_array($role, $validOptions)) {
        header("Location: ../employee/index.php?error=invalidrole");
        exit();
    }

    require_once '../db/dbh.inc.php';
    require_once 'userfunctions.inc.php';

    if (emptyInputSignup($firstname, $lastname, $email, $pwd, $pwdRepeat) !== false) {
        header("Location: ../employee/?error=emptyfields");
        exit();
    }
    if (invalidFirstname($firstname) !== false) {
        header("Location: ../employee/?error=invalidfirstname");
        exit();
    }
    if (invalidLastname($lastname) !== false) {
        header("Location: ../employee/?error=invalidlastname");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("Location: ../employee/?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("Location: ../employee/?error=nopasswordmatch");
        exit();
    }

    if (emailExists($conn, $email) !== false) {
        header("Location: ../employee/?error=emailexists");
        exit();
    }

    createUser($conn, $firstname, $lastname, $email, $pwd, $role);
} else {
    header("Location: ../employee/");
}
