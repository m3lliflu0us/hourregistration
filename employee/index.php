<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

$currentPage = 'employee';


include("../config.php");
include("../userincludes/userfunctions.inc.php");
include("../db/dbh.inc.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
    <title>Medewerkers | Gilde DevOps</title>
    <link rel="stylesheet" href="employee.css">
    <link rel="stylesheet" href="../assets/layout.css">
    <link rel="stylesheet" href="../assets/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <?php include("../assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
                <div class="employee-container">
                    <div class="createassignment-wrapper">
                        <form action="../assignment/assignment.php" method="post">
                            <div class="info-main">
                                <span>
                                    Creëer een opdracht
                                </span>
                                <div class="info-extra">
                                    Voer de gegevens in om een account te maken
                                </div>
                            </div>
                            <div class="assignmentName">
                                <input type="text" name="assignmentName" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="assignmentName">Opdracht Naam</label>
                            </div>
                            <div class="assignmentDescription">
                                <input type="text" name="assignmentDescription" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="assignmentDescription">Opdracht beschrijving</label>
                            </div>
                            <div class="companyName">
                                <label for="companyName">Bedrijfsnaam</label>
                                <select name="companyName">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT companyName FROM client");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['companyName']}'>{$row['companyName']}</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="assignmentDeadline">
                                <input type="date" id="deadline" name="deadline">
                                <label for="deadline">Deadline:</label>
                            </div>

                            <div class="create">
                                <input type="submit" name="createassignment" value="Creëer">
                            </div>
                        </form>
                    </div>

                    <div class="border">

                    </div>
                    <div class="createemployee-wrapper">
                        <form action="../userincludes/signup.inc.php" method="POST">
                            <div class="info-main">
                                <span>
                                    Een account maken
                                </span>
                            </div>
                            <div class="info-extra">
                                <span>
                                    Voer de gegevens in om een opdracht te maken
                                </span>
                            </div>
                            <div class="fName">
                                <input type="text" name="firstname" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="firstname">Voornaam</label>
                            </div>

                            <div class="lName">
                                <input type="text" name="lastname" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="lastname">Achternaam</label>
                            </div>

                            <div class="eMail">
                                <input type="text" name="email" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="email">E-mailadres</label>
                            </div>

                            <select name="role">
                                <optgroup label="Rechten">
                                    <option value="administrator">Administrator</option>
                                    <option value="SD">SD</option>
                                    <option value="ITSD">ITSD</option>
                                    <option value="hybrid">Hybrid</option>
                                </optgroup>
                            </select>

                            <div class="pwd">
                                <input type="password" name="pwd" value="" id="pwd" onkeyup="this.setAttribute('value', this.value);">
                                <label for="pwd">Wachtwoord</label>
                            </div>

                            <div class="pwd-rpt">
                                <input type="password" name="pwdRepeat" value="" id="pwdRpt" onkeyup="this.setAttribute('value', this.value);">
                                <label for="pwdRepeat">Herhaal wachtwoord</label>
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

                            <label class="checkBox-wrapper">
                                Wachtwoord(en) tonen
                                <input type="checkBox" onclick="togglePwd(), togglePwdRpt()">
                                <span class="checkMark"></span>
                            </label>

                            <div class="Create">
                                <input type="submit" name="submit" value="Creëer">
                            </div>
                        </form>
                    </div>

                    <div class="border"></div>

                    <div class="employeelist-wrapper">
                        <?php
                        $sql = "SELECT * FROM user";
                        $result = $conn->query($sql);

                        $users = array();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $users[] = $row;
                            }
                        } else {
                            echo "<div><span>0 results</span></div>";
                        }
                        $conn->close();
                        ?>

                        <div class="info-main">
                            <span>Alle werknemers</span>
                        </div>
                        <div class="info-extra">
                            <span>hier kunt u alle werknemers zien</span>
                        </div>

                        <?php foreach ($users as $user) : ?>
                            <div class="employeelist-item">
                                <div class="name">
                                    <span>Naam: <?php echo $user['userFirstname']; ?></span>
                                    <span><?php echo $user['userLastname']; ?></span>
                                </div>
                                <span>E-mail: <?php echo $user['userEmail']; ?></span>
                                <span>Rechten: <?php echo $user['userRole']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </main>
</body>

</html>