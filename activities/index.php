<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

$currentPage = 'activities';

include("../config.php");
include("../userincludes/userfunctions.inc.php");
include("../db/dbh.inc.php");

// Query om de benodigde gegevens op te halen
$sql = "SELECT user.userFirstname, user.userLastname, assignment.assignmentName, assignment.assignmentDescription, assignment.assignmentId, activity.totalTime 
        FROM user 
        JOIN activity ON user.userId = activity.userId 
        JOIN assignment ON activity.assignmentId = assignment.assignmentId";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
    <title>Werkzaamheden | Gilde DevOps</title>
    <link rel="stylesheet" href="activities.css">
    <link rel="stylesheet" href="../assets/layout.css">
    <link rel="stylesheet" href="../assets/navbar.css">
    <script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    tdName = tr[i].getElementsByTagName("td")[0];
    tdAssignment = tr[i].getElementsByTagName("td")[1];
    if (tdName || tdAssignment) {
      txtValueName = tdName.textContent || tdName.innerText;
      txtValueAssignment = tdAssignment.textContent || tdAssignment.innerText;
      if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueAssignment.toUpperCase().indexOf(filter) > -1) {
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
        <?php include("../assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
                <?php
               if ($result->num_rows > 0) {
                // Maak een zoekbalk
                echo "<input class='search-bar' type='text' id='myInput' onkeyup='myFunction()' placeholder='Zoek naar namen..'>";
                echo "<table class='data-table' id='myTable'>";
                echo "<tr class='header'><th>Naam</th><th>Opdracht</th><th>Opdracht Omschrijving</th><th>Opdracht ID</th><th>Totale tijd</th></tr>";
                
                // Output data van elke rij
                while($row = $result->fetch_assoc()) {
                    $totalTime = $row["totalTime"];
                    if ($totalTime == 0) {
                        continue; // Skip this row
                    }
                    $totalTimeFormatted = gmdate("H:i:s", $totalTime);
                    $firstName = ucfirst(strtolower($row["userFirstname"]));
                    $lastName = ucfirst(strtolower($row["userLastname"]));
<<<<<<< Updated upstream
                    echo "<tr><td>" . $firstName . " " . $lastName . "</td><td>" . $row["assignmentName"]. "</td><td>" . $row["assignmentDescription"]. "</td><td>" . $row["assignmentId"]. "</td><td>" . $totalTime . "</td></tr>";
=======
                    echo "<tr><td>" . $firstName . " " . $lastName . "</td><td>" . $row["assignmentName"]. "</td><td>" . $row["assignmentDescription"]. "</td><td>" . $row["userId"]. "</td><td>" . $totalTimeFormatted . "</td></tr>";
>>>>>>> Stashed changes
                }
                
                echo "</table>"; // Close the table
              }
              
                ?>
            </div>
        </div>
        
    </main>
</body>

</html>
