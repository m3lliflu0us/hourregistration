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
$sql = "SELECT user.userFirstname, user.userLastname, assignment.assignmentName, activity.totalTime 
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
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
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
                  echo "<input type='text' id='myInput' onkeyup='myFunction()' placeholder='Zoek naar namen..'>";

                  // Maak een tabel om de resultaten weer te geven
                  echo "<table id='myTable'>";
                  echo "<tr class='header'><th>Naam</th><th>Opdracht</th><th>Totale tijd</th></tr>";
                  
                  // Output data van elke rij
                  while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["userFirstname"]. " " . $row["userLastname"]. "</td><td>" . $row["assignmentName"]. "</td><td>" . $row["totalTime"]. "</td></tr>";
                  }
                  echo "</table>";
                } else {
                  echo "0 resultaten";
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>

