<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: user/login.php");
    exit();
}

$currentPage = 'dashboard';

include("config.php");
include("./db/dbh.inc.php");
include("./userincludes/userfunctions.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Gilde DevOps</title>
    <link rel="stylesheet" href="./dashboard/dashboard.css">
    <link rel="stylesheet" href="./assets/layout.css">
    <link rel="stylesheet" href="./assets/navbar.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Role', 'Hours Worked'],
                <?php
                $sql = "SELECT user.userRole, SUM(activity.totalTime) as totalHours FROM user INNER JOIN activity ON user.userId = activity.userId GROUP BY user.userRole";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "['" . $row['userRole'] . "', " . $row['totalHours'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Hours Worked by Each Role',
                hAxis: {
                    title: 'Role',
                },
                vAxis: {
                    title: 'Hours Worked'
                },
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <main>
        <?php include("./assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
            <div id="columnchart" style="width: 900px; height: 500px;"></div>
            </div>
        </div>
    </main>
</body>

</html>
