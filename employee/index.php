<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

include("../config.php");
include("../userincludes/userfunctions.inc.php");
include("../db/dbh.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Gilde DevOps</title>
    <link rel="stylesheet" href="employee.css">
    <link rel="stylesheet" href="../assets/layout.css">

</head>

<body>
    <main>
        <?php include("../assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
                <div class="employee-container">
                    <div class="create-assignment-wrapper">
                        <form action="../assignment/assignment.php" method="post">
                            <div class="inf">
                                <span>
                                    Creëer een opdracht
                                </span>
                                <div class="inf-title">
                                    Voer de gegevens in om een account te maken

                                </div>
                            </div>
                            <div class="assignmentInput">
                                <input type="text" name="assignmentName" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="assignmentName">Opdracht Naam</label>
                            </div>
                            <div class="assignmentInput">
                                <input type="text" name="assignmentDescription" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="assignmentDescription">Opdracht uitleg</label>
                            </div>
                            <div class="clientId">
                                <label for="clientId">clientId</label>

                                <select name="clientId">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT clientId FROM client");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['clientId']}'>{$row['clientId']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <label for="deadline">Deadline:</label>
                            <input type="date" id="deadline" name="deadline">

                            <div class="create">
                                <input type="submit" name="createassignment" value="Creëer">
                            </div>
                        </form>
                    </div>
                    <div class="box-wrapper">
                        <div class="left">
                            <div class="inf">
                                <span>
                                    Een account maken
                                </span>
                            </div>
                            <div class="ins">
                                <span>
                                    Voer de gegevens in om een opdracht te maken
                                </span>
                            </div>
                        </div>
                        <div class="right">
                            <form action="../userincludes/signup.inc.php" method="POST">
                                <div class="firstname">
                                    <input type="text" name="firstname" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="firstname">Voornaam</label>
                                </div>

                                <div class="lastname">
                                    <input type="text" name="lastname" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="lastname">Achternaam</label>
                                </div>

                                <div class="email margin">
                                    <input type="text" name="email" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="email">E-mailadres</label>
                                </div>

                                <select name="role">
                                    <option value="administrator">Administrator</option>
                                    <option value="SD">SD</option>
                                    <option value="ITSD">ITSD</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>


                                <div class="password">
                                    <input type="password" name="pwd" value="" id="pwd" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="pwd">Wachtwoord</label>
                                </div>

                                <div class="password-repeat">
                                    <input type="password" name="pwdRepeat" value="" id="pwdRpt" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="pwd-rpt">Herhaal wachtwoord</label>
                                </div>

                                <div class="error-container">
                                    <?php
                                    if (isset($_GET["error"])) {
                                        if ($_GET["error"] == "emptyfields") {
                                            echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                            echo "<span style='color: #b3261e; font-size: 12px'>Please fill in all fields</span>";
                                            echo "<script>document.querySelector('.firstname input').classList.add('error');
                                document.querySelector('.firstname label').classList.add('error');</script>";
                                        } else if ($_GET["error"] == "invalidfirstname") {
                                            echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                            echo "<p style='color: #b3261e;font-size: 12px' >Invalid firstname, please try again</p>";
                                        } else if ($_GET["error"] == "invalidlastname") {
                                            echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                            echo "<p style='color: #b3261e;font-size: 12px'>Invalid lastname, please try again</p>";
                                        } else if ($_GET["error"] == "invalidemail") {
                                            echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                            echo "<p style='color: #b3261e;font-size: 12px'>invalid email address, please try again</p>";
                                        } else if ($_GET["error"] == "nopasswordmatch") {
                                            echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                            echo "<p style='color: #b3261e;font-size: 12px'>Passwords do not match, please try again</p>";
                                        } else if ($_GET["error"] == "passwordtooweak") {
                                            echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                            echo "<p style='color: #b3261e;font-size: 12px'>Passwords is too weak, please use atleast one uppercase letter, one lowercase letter, one number and one special character</p>";
                                        }
                                    }
                                    ?>
                                </div>

                                <label class="checkbox-container">
                                    Wachtwoord(en) tonen
                                    <input type="checkbox" onclick="togglePwd(), togglePwdRpt()">
                                    <span class="checkmark"></span>
                                </label>

                                <div class="bottom">
                                    <div class="submit">
                                        <input type="submit" name="submit" value="Creëer">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </main>
</body>

</html>

<script>
    function togglePwd() {
        var x = document.getElementById("pwd");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function togglePwdRpt() {
        var x = document.getElementById("pwdRpt");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>