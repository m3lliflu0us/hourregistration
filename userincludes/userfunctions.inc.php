<?php

function emptyInputSignup($firstname, $lastname, $email, $pwd, $pwdRepeat)
{
    $result = true;
    if (empty($firstname) || empty($lastname) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidFirstname($firstname)
{
    $result = true;
    if (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidLastname($lastname)
{
    $result = true;
    if (!preg_match("/^[a-zA-Z]+([- ]?[a-zA-Z]+)*$/", $lastname)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    $result = true;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat)
{
    $result = true;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM user WHERE userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../user/signup.php?error=somethingwentwrong");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $firstname, $lastname, $email, $pwd, $role)
{
    $sql = "INSERT INTO user (userFirstname, userLastname, userEmail, userPwd, userRole) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../user/signup.php?error=somethingwentwrong");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $hashedPwd, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../user/login.php?error=none");
    exit();
}

function loginUser($conn, $email, $pwd)
{
    $emailExists = emailExists($conn, $email);

    if ($emailExists === false) {
        header("location: ../user/login.php?error=incorrectlogin");
        exit();
    }

    $pwdHashed = $emailExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../user/login.php?error=incorrectlogin");
        exit();
    } elseif ($checkPwd === true) {
        session_start();
        $_SESSION["userId"] = $emailExists["userId"];
        $_SESSION["userEmail"] = $emailExists["userEmail"];
        $_SESSION["userFirstname"] = ucfirst($emailExists["userFirstname"]);
        $_SESSION["userRole"] = $emailExists["userRole"];

        $lastnameParts = explode(' ', $emailExists["userLastname"]);
        $lastnameInitial = ucfirst(substr(end($lastnameParts), 0, 1));
        $_SESSION["userLastnameInitial"] = $lastnameInitial;

        header("location: ../");
        exit();
    }
}


function emptyInputLogin($email, $pwd)
{
    $result = true;
    if (empty($email) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
