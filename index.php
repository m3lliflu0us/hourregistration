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
'packages': ['corechart', 'calendar']
});
google.charts.setOnLoadCallback(drawPieChart);
google.charts.setOnLoadCallback(drawColumnChart);
google.charts.setOnLoadCallback(drawDotChart);

function drawPieChart() {
var data = google.visualization.arrayToDataTable([
['Recht', 'Aantal gebruikers'],
<?php
$sql = "SELECT userRole, COUNT(*) as number FROM user GROUP BY userRole";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
echo "['" . $row['userRole'] . "', " . $row['number'] . "],";
}
?>
]);

var options = {
title: 'Gebruiker recht distributie',
colors: ['#ca2b69', '#b82bca', '#692bca', '#ca692b', ],
backgroundColor: '#eee',
};

var chart = new google.visualization.PieChart(document.getElementById('piechart'));

chart.draw(data, options);
}

function drawColumnChart() {
var data = google.visualization.arrayToDataTable([
['User', 'Total Time Worked'],
<?php
$sql = "SELECT userFirstname, SUM(totalTime) as totalTime FROM user JOIN activity ON user.userId = activity.userId GROUP BY user.userId";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
$totalTime = is_null($row['totalTime']) ? 0 : $row['totalTime'];
echo "['" . $row['userFirstname'] . "', " . $totalTime . "],";
}
?>
]);

var options = {
title: 'Total Time Worked per User',
hAxis: {
title: 'User',
minValue: 0
},
vAxis: {
title: 'Total Time Worked'
},
colors: ['#ca2b69'],
backgroundColor: '#eee',

};

var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
chart.draw(data, options);
}

function drawDotChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'User');
    data.addColumn('number', 'Total Time Worked');

    <?php
    $sql = "SELECT userFirstname, SUM(totalTime) as totalTime FROM user JOIN activity ON user.userId = activity.userId GROUP BY user.userId";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $totalTime = is_null($row['totalTime']) ? 0 : $row['totalTime'];
        echo "data.addRow(['" . $row['userFirstname'] . "', " . $totalTime . "]);";
    }
    ?>

    var options = {
        title: 'Total Time Worked per User',
        hAxis: {
            title: 'User',
            minValue: 0
        },
        vAxis: {
            title: 'Total Time Worked'
        },
        colors: ['#ca2b69'],
        legend: 'none',
        pointSize: 5,
        backgroundColor: '#eee'
    };

    var chart = new google.visualization.ScatterChart(document.getElementById('dotchart'));
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
<div id="columnchart" style="width: 100%; height: 100%; fill: #ca2b69;"></div>
</div>

<div class="dotchart-wrapper">
<div id="dotchart" style="width: 100%; height: 100%;"></div>
</div>


<div class="totalHours-wrapper">
<?php
$userId = $_SESSION['userId'];

$sql = "SELECT SUM(activity.totalTime) as totalTime FROM user JOIN activity ON user.userId = activity.userId WHERE user.userId = $userId GROUP BY user.userId";
$result = $conn->query($sql);

echo '<div class="total-worked-wrapper">';
echo '<div class="totalHours-title"><span>Totaal gewerkte tijd</span></div>';
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$totalTime = $row["totalTime"];
$totalTime = ($totalTime == 0) ? '0 seconds' : gmdate("H:i:s", $totalTime);
echo '<div class="totalHours-text"><span>' . $totalTime . '</span></div>';
} else {
echo "<div class='totalHours-text'><span>Geen resultaten</span></div>";
}
echo '</div>';
?>
</div>

<div class="piechart-wrapper">
<div id="piechart" style="width: 100%; height: 100%;"></div>
</div>

<div class="workingNow-wrapper">
<?php
$sql = "SELECT user.userFirstname, user.userLastname FROM user JOIN activity ON user.userId = activity.userId WHERE activity.clockedIn = 1";
$result = $conn->query($sql);

echo '<div class="workingNow-list">';
echo '<div class="workingNow-title"><span>Ingeklokt</span></div>';
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$lastnameParts = explode(' ', $row["userLastname"]);
$lastnameInitial = ucfirst(substr(end($lastnameParts), 0, 1));
echo '<div class="workingNow-text"><span>' . $row["userFirstname"] . ' ' . $lastnameInitial . '</span></div>';
}
} else {
echo "<div class='workingNow-text'><span>Geen werknemers ingeklokt</span></div>";

}
echo '</div>';

echo '<div class="border"></div>';

$sql = "SELECT COUNT(*) as count FROM user JOIN activity ON user.userId = activity.userId WHERE activity.clockedIn = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo '<div class="workingNow-count">';
echo '<div class="workingNow-title"><span>Werknemers ingeklokt</span></div>';
echo '<div class="workingNow-text"><span>' . $row["count"] . '</span></div>';
echo '</div>';
?>
</div>

<?php
$sql = "SELECT user.userFirstname, user.userLastname, SUM(activity.totalTime) as totalTime FROM user JOIN activity ON user.userId = activity.userId GROUP BY user.userId";
$result = $conn->query($sql);

echo '<div class="leaderboard-wrapper">';
echo '<div class="leaderboard-title"><span>Leaderboard</span></div>';
if ($result->num_rows > 0) {
$counter = 1;
while ($row = $result->fetch_assoc()) {
$lastnameParts = explode(' ', $row["userLastname"]);
$lastnameInitial = ucfirst(substr(end($lastnameParts), 0, 1));
$totalTime = $row["totalTime"];
$totalTime = ($totalTime == 0) ? '00:00:00' : gmdate("H:i:s", $totalTime);
echo '<div class="leaderboard-text"><span>' . $counter . '. ' . $row["userFirstname"] . ' ' . $lastnameInitial . ': ' . $totalTime . '</span></div>';
$counter++;
}
} else {
echo "<div class='leaderboard-text'><span>Geen resultaten</span></div>";
}
echo '</div>';
?>
</div>

</div>
</div>
</main>
</body>

</html>