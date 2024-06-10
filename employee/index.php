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

<script>
    // JavaScript function to handle select change
    function handleSelectChange(radio) {
        // Get all radio buttons
        var radios = document.querySelectorAll('.custom-select-option');
        // Loop through radio buttons
        for (var i = 0; i < radios.length; i++) {
            // If the radio button is checked
            if (radios[i].checked) {
                // Add 'checked' class to the label
                radios[i].nextElementSibling.classList.add('checked');
            } else {
                // Remove 'checked' class from the label
                radios[i].nextElementSibling.classList.remove('checked');
            }
        }
    }
</script>

<body>
    <main>
        <?php include("../assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
                <div class="employee-container">
                    <div class="heading-wrapper">
                        Medewerkers
                    </div>
                    <div class="createassignment-wrapper">
                        <form action="../assignment/assignment.php" method="post">
                            <div class="subheading-wrapper">
                                <span>
                                    Creëer een opdracht
                                </span>
                            </div>
                            <div class="input">
                                <input type="text" name="assignmentName" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="assignmentName">Opdracht Naam</label>
                            </div>
                            <div class="input">
                                <input type="text" name="assignmentDescription" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="assignmentDescription">Opdracht beschrijving</label>
                            </div>
                            <!-- Custom Select Dropdown with Animated Label -->
                            <!-- Custom Select Dropdown with Animated Label -->
                            <div class="custom-select-container" tabindex="1">
                                <label for="custom-select" class="custom-select-label">Bedrijfsnaam</label>
                                <div class="custom-select">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT companyName FROM client");
                                    $idCounter = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $companyName = $row['companyName'];
                                        echo "<input class='custom-select-option' name='companyName' type='radio' id='custom-opt$idCounter'>";
                                        echo "<label for='custom-opt$idCounter' class='custom-option'>$companyName</label>";
                                        $idCounter++;
                                    }
                                    ?>
                                </div>
                            </div>


                            <div class="input">
                                <input type="date" id="deadline" name="deadline">
                                <label for="deadline">Deadline:</label>
                            </div>

                            <div class="submit-button">
                                <input type="submit" name="createassignment" value="Creëer">
                            </div>
                        </form>
                    </div>

                    <div class="createemployee-wrapper">
                        <form action="../userincludes/signup.inc.php" method="POST">
                            <div class="subheading-wrapper">
                                <span>
                                    Een account maken
                                </span>
                            </div>
                            <div class="input">
                                <input type="text" name="firstname" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="firstname">Voornaam</label>
                            </div>

                            <div class="input">
                                <input type="text" name="lastname" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="lastname">Achternaam</label>
                            </div>

                            <div class="input">
                                <input type="text" name="email" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="email">E-mailadres</label>
                            </div>

                            <select name="role">
                                <option value="administrator">Administrator</option>
                                <option value="SD">SD</option>
                                <option value="ITSD">ITSD</option>
                                <option value="hybrid">Hybrid</option>
                            </select>

                            <div class="input">
                                <input type="password" name="pwd" value="" id="pwd" onkeyup="this.setAttribute('value', this.value);">
                                <label for="pwd">Wachtwoord</label>
                            </div>

                            <div class="input">
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

                            <div class="submit-button">
                                <input type="submit" name="submit" value="Registreer">
                            </div>
                        </form>
                    </div>

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

                        <div class="subheading-wrapper">
                            <span>Alle werknemers</span>
                        </div>

                        <?php foreach ($users as $user) : ?>
                            <div class="employeelist-item">
                                <div class="name">
                                    <span><span class="bolder">Naam: </span><?php echo $user['userFirstname']; ?></span>
                                    <span><?php echo $user['userLastname']; ?></span>
                                </div>
                                <span><span class="bolder">E-mail: </span><?php echo $user['userEmail']; ?></span>
                                <span><span class="bolder">Rechten: </span><?php echo $user['userRole']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </main>
</body>

</html>