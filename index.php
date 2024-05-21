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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawPieChart);
        google.charts.setOnLoadCallback(drawColumnChart);

        function drawPieChart() {
            var data = google.visualization.arrayToDataTable([
                ['Role', 'Number of Users'],
                <?php
                $sql = "SELECT userRole, COUNT(*) as number FROM user GROUP BY userRole";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "['" . $row['userRole'] . "', " . $row['number'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'User Roles Distribution'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }

        function drawColumnChart() {
            var data = google.visualization.arrayToDataTable([
                ['Role', 'Hours Worked'],
                <?php
                $sql = "SELECT user.userRole, COALESCE(SUM(activity.totalTime), 0) as totalHours FROM user LEFT JOIN activity ON user.userId = activity.userId GROUP BY user.userRole";
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
                <div class="dashboard-content">
                    <div class="title-wrapper">
                        <?php
                        date_default_timezone_set('Europe/Amsterdam');
                        $hour = date('H');
                        $greeting = '';

                        if ($hour >= 0 && $hour < 12) {
                            $greeting = 'Goedemorgen';
                        } elseif ($hour >= 12 && $hour < 18) {
                            $greeting = 'Goedemiddag';
                        } else {
                            $greeting = 'Goedeavond';
                        }
                        ?>

                        <span>
                            <?= $greeting . " " . $_SESSION["userFirstname"]; ?>
                        </span>
                    </div>
                    <div class="columnchart-wrapper">
                        <div id="columnchart" style="width: 100%; height: 100%;"></div>
                    </div>
                    <div class="activitychart-wrapper">
                        activitychart
                    </div>
                    <div class="totalHours-wrapper">
                        total hours worked
                    </div>
                    <div class="piechart-wrapper">
                        <div id="piechart" style="width: 100%; height: 100%;"></div>
                    </div>
                    <div class="workingNow-wrapper">
                        working now
                    </div>
                    <div class="leaderboard-wrapper">
                        leaderboard
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>