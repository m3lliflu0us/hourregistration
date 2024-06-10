<?php
session_start();

if (!isset($_SESSION["userId"])) {
  header("Location: ../user/login.php");
  exit();
}

$currentPage = 'activities';

include("../config.php");
include("../userincludes/userfunctions.inc.php");
include("../db/dbh.inc.php");

$sql = "SELECT user.userId, user.userFirstname, user.userLastname, assignment.assignmentName, assignment.assignmentDescription, activity.totalTime 
        FROM user 
        JOIN activity ON user.userId = activity.userId 
        JOIN assignment ON activity.assignmentId = assignment.assignmentId";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!-- Removed duplicate lang attribute in meta tag -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Werkzaamheden | Gilde DevOps</title>
  <link rel="stylesheet" href="activities.css">
  <link rel="stylesheet" href="../assets/layout.css">
  <link rel="stylesheet" href="../assets/navbar.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  <script>
    function searchFunction() {
      var input, filter, table, tr, tdName, tdAssignment, tdUserId, i, txtValueName, txtValueAssignment, txtValueUserId;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        tdName = tr[i].getElementsByTagName("td")[0];
        tdAssignment = tr[i].getElementsByTagName("td")[1];
        tdUserId = tr[i].getElementsByTagName("td")[3];
        if (tdName && tdAssignment && tdUserId) {
          txtValueName = tdName.textContent || tdName.innerText;
          txtValueAssignment = tdAssignment.textContent || tdAssignment.innerText;
          txtValueUserId = tdUserId.textContent || tdUserId.innerText;
          if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueAssignment.toUpperCase().indexOf(filter) > -1 || txtValueUserId.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>

</head>

<body>
  <main>
    <?php include("../assets/navbar.php"); ?>

    <div class="dashboard-wrapper">
      <div class="dashboard-window">
        <div class="activities-wrapper">
          <?php
          if ($result->num_rows > 0) {
            // Fixed the onkeyup attribute by escaping double quotes
            echo "<div class='search'><input name='search' type='text' id='myInput' onkeyup=\"this.setAttribute('value', this.value); searchFunction();\">
";
            echo '<label for="search">Zoek naar opdrachtnaam of ID</label></div>';
            echo "<table class='data-table' id='myTable'>";
            echo "<tr class='header'><th>Naam</th><th>Opdrachtnaam</th><th>Opdracht Omschrijving</th><th>Gebruiker ID</th><th>Totale tijd</th></tr>";

            while ($row = $result->fetch_assoc()) {
              $totalTime = $row["totalTime"];
              if ($totalTime == 0) {
                continue;
              }
              $totalHours = $totalTime / 3600;
              $roundedHours = ceil($totalHours * 2) / 2;
              $totalTimeFormatted = number_format($roundedHours, 1, '.', '') . " uur";

              $firstName = ucfirst(strtolower($row["userFirstname"]));
              $lastName = ucfirst(strtolower($row["userLastname"]));
              echo "<tr><td>" . $firstName . " " . $lastName . "</td><td>" . $row["assignmentName"] . "</td><td>" . $row["assignmentDescription"] . "</td><td>" . $row["userId"] . "</td><td>" . $totalTimeFormatted . "</td></tr>";
            }

            echo "</table>";
          } else {
            // Added an else statement to handle the case when there are no results
            echo "Geen activiteiten gevonden.";
          }
          ?>
        </div>
      </div>
    </div>
  </main>
</body>

</html>