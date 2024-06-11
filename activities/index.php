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
              echo '<span class="subheading">Medewerker</span>';
              echo '<span><span class="bolder">ID: </span>' . htmlspecialchars($row["userId"]) . '</span>';
              echo '<span><span class="bolder">Naam: </span><a class="link" href="../employee/index.php?highlight=' . urlencode(htmlspecialchars($row["userFirstname"] . ' ' . $row["userLastname"])) . '" class="highlight-name">' . htmlspecialchars($row["userFirstname"]) . ' ' . htmlspecialchars($row["userLastname"]) . '</a></span>';
              echo '<span><span class="bolder">E-mailadress: </span><a class="link" href="mailto:' . htmlspecialchars($row["userEmail"]) . '">' . htmlspecialchars($row["userEmail"]) . '</a></span>';
              echo '<span><span class="bolder">Ingeklokt: </span>' . ($row["clockedIn"] ? 'Ja' : 'Nee') . '</span>';
              echo '</div>';

              echo '<div class="client-wrapper">';
              echo '<span class="subheading">Klant</span>';
              echo '<span><span class="bolder">ID: </span>' . htmlspecialchars($row["clientId"]) . '</span>';
              echo '<span><span class="bolder">Naam: </span>' . htmlspecialchars($row["clientFirstname"]) . " " . htmlspecialchars($row["clientLastname"]) . '</span>';
              echo '<span><span class="bolder">Telefoonnummer: </span>' . htmlspecialchars($row["clientPhoneNumber"]) . '</span>';
              echo '<span><span class="bolder">Bedrijfsnaam: </span>' . htmlspecialchars($row["companyName"]) . '</span>';
              echo '</div>';

              echo '<div class="assignment-wrapper">';
              echo '<span class="subheading">Opdracht</span>';
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