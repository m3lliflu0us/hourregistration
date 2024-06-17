<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: ../user/login.php");
    exit();
}

$currentPage = 'activities';


include("../config.php");
include("../db/dbh.inc.php");
include("activities.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Werkzaamheden | Gilde DevOps</title>
    <link rel="stylesheet" href="activities.css">
    <link rel="stylesheet" href="../assets/layout.css">
    <link rel="stylesheet" href="../assets/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <?php include("../assets/navbar.php"); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
                <div class="activities-wrapper">

                    <div class="heading-wrapper">
                        <span>
                            Werkzaamheden
                        </span>
                    </div>

                    <form class="search-wrapper" action="" method="post">
                        <div class="search">
                            <input type="text" name="searchTerm" value="" onkeyup="this.setAttribute('value', this.value);">
                            <label for="searchTerm">Zoeken...</label>
                            <button type="submit" name="search">Search</button>
                        </div>
                    </form>

                    <div class="activities-item-wrapper">
                        <?php
                        $activities = isset($_POST['search']) ? fetchActivities($_POST['searchTerm']) : fetchActivities();

                        foreach ($activities as $row) {
                            if (is_null($row["clockedBegin"]) && is_null($row["clockedEnd"])) {
                                continue;
                            }
                            echo '<div class="activity-item">';
                            echo '<div class="employee-wrapper">';
                            echo '<a class="link" href="../employee/index.php?highlight=' . urlencode($row["userId"]) . '"><span class="subheading">Medewerker</span></a>';
                            echo '<span><span class="bolder">ID: </span>' . htmlspecialchars($row["userId"]) . '</span>';
                            echo '<span><span class="bolder">Naam: </span>' . htmlspecialchars($row["userFirstname"]) . ' ' . htmlspecialchars($row["userLastname"]) . '</span>';
                            echo '<span><span class="bolder">E-mailadres: </span>' . htmlspecialchars($row["userEmail"]) . '</span>';
                            echo '<span><span class="bolder">Ingeklokt: </span>' . ($row["clockedIn"] ? 'Ja' : 'Nee') . '</span>';
                            echo '</div>';

                            echo '<div class="client-wrapper">';
                            echo '<a class="link" href="../client/index.php?highlight=' . urlencode($row["clientId"]) . '"><span class="subheading">Klant</span></a>';
                            echo '<span><span class="bolder">ID: </span>' . htmlspecialchars($row["clientId"]) . '</span>';
                            echo '<span><span class="bolder">Naam: </span>' . htmlspecialchars($row["clientFirstname"]) . ' ' . htmlspecialchars($row["clientLastname"]) . '</span>';
                            echo '<span><span class="bolder">E-mailadress: </span>' . htmlspecialchars($row["clientEmail"]) . '</span>';
                            echo '<span><span class="bolder">Telefoonnummer: </span>' . htmlspecialchars($row["clientPhoneNumber"]) . '</span>';
                            echo '<span><span class="bolder">Bedrijfsnaam: </span>' . htmlspecialchars($row["companyName"]) . '</span>';
                            echo '</div>';

                            echo '<div class="assignment-wrapper">';
                            echo '<a class="link" href="../assignment/index.php?highlight=' . urlencode($row["assignmentId"]) . '"><span class="subheading">Opdracht</span></a>';
                            echo '<span><span class="bolder">ID: </span>' . htmlspecialchars($row["assignmentId"]) . '</span>';
                            echo '<span><span class="bolder">Opdracht naam: </span>' . htmlspecialchars($row["assignmentName"]) . '</span>';
                            echo '<span><span class="bolder">Totale tijd(in uren): </span>' . (!is_null($row["totalTimeHours"]) ? $row["totalTimeHours"] : '') . '</span>';
                            echo '<span><span class="bolder">Deadline: </span>' . (!is_null($row["deadline"]) ? htmlspecialchars($row["deadline"]) : 'Geen deadline') . '</span>';
                            echo '</div>';

                            echo '</div>';
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </main>
</body>

</html>