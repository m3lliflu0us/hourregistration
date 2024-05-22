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

// Get data from database
$result = $conn->query("SELECT DATE(clockedBegin) as date, COUNT(*) as count FROM activity WHERE YEAR(clockedBegin) = YEAR(CURDATE()) AND clockedIn = 1 GROUP BY date");

// Prepare data for the chart
$data = [];
while ($row = $result->fetch_assoc()) {
$data[$row['date']] = $row['count'];
}
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
<script src="https://d3js.org/d3.v5.min.js"></script>
<style>
.day {
width: 10px;
height: 10px;
margin-right: 1px;
margin-bottom: 1px;
}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {
'packages': ['corechart', 'calendar']
});
google.charts.setOnLoadCallback(drawPieChart);
google.charts.setOnLoadCallback(drawColumnChart);

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
title: 'Gebruiker recht distributie'
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
}
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
<div id="chart" style="height: 100%; width: 100%;"></div>

<script>
var data = <?php echo json_encode($data); ?>;
var colors = ['#eeeeee', '#d6e685', '#8cc665', '#44a340', '#1e6823'];

// Calculate the number of rows and columns
var numCols = Math.ceil(Math.sqrt(Object.keys(data).length));
var numRows = Math.ceil(Object.keys(data).length / numCols);

// Calculate the SVG element's width and height
var svgWidth = numCols * 12; // 10px for rect width and 2px for margin
var svgHeight = numRows * 12; // 10px for rect height and 2px for margin

var svg = d3.select('#chart')
.append('svg')
.attr('width', svgWidth)
.attr('height', svgHeight);

var x = 0;
var y = 0;
for (var date in data) {
var count = data[date];
var color;
if (count >= 6) {
color = colors[4];
} else if (count >= 4) {
color = colors[3];
} else if (count >= 2) {
color = colors[2];
} else if (count == 1) {
color = colors[1];
} else {
color = colors[0];
}

svg.append('rect')
.attr('x', x)
.attr('y', y)
.attr('width', 10)
.attr('height', 10)
.style('fill', color);

x += 12;
if (x >= svgWidth) {
x = 0;
y += 12;
}
}
console.log(data);

</script>
</div>
<div class="totalHours-wrapper">
<?php
$userId = $_SESSION['userId'];

$sql = "SELECT SUM(activity.totalTime) as totalTime FROM user JOIN activity ON user.userId = activity.userId WHERE user.userId = $userId GROUP BY user.userId";
$result = $conn->query($sql);

echo '<div class="total-worked-wrapper">';
echo '<div><span>Totaal gewerkte tijd</span></div>';
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$totalTime = $row["totalTime"];
$totalTime = ($totalTime == 0) ? '0 seconds' : gmdate("H:i:s", $totalTime);
echo '<span>' . $totalTime . '</span>';
} else {
echo "Geen resultaten";
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
echo '<div><span>Ingeklokt</span></div>';
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$lastnameParts = explode(' ', $row["userLastname"]);
$lastnameInitial = ucfirst(substr(end($lastnameParts), 0, 1));
echo '<span>' . $row["userFirstname"] . ' ' . $lastnameInitial . '</span>';
}
} else {
echo "Geen werknemers ingeklokt";
}
echo '</div>';

echo '<div class="border"></div>';

$sql = "SELECT COUNT(*) as count FROM user JOIN activity ON user.userId = activity.userId WHERE activity.clockedIn = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo '<div class="workingNow-count">';
echo '<div><span>Werknemers ingeklokt</span></div>';
echo '<span>' . $row["count"] . '</span>';
echo '</div>';

?>
</div>
<?php
$sql = "SELECT user.userFirstname, user.userLastname, SUM(activity.totalTime) as totalTime FROM user JOIN activity ON user.userId = activity.userId GROUP BY user.userId";
$result = $conn->query($sql);

echo '<div class="leaderboard-wrapper">';
echo '<div><span>Leaderboard</span></div>';
if ($result->num_rows > 0) {
$counter = 1;
while ($row = $result->fetch_assoc()) {
$lastnameParts = explode(' ', $row["userLastname"]);
$lastnameInitial = ucfirst(substr(end($lastnameParts), 0, 1));
$totalTime = $row["totalTime"];
$totalTime = ($totalTime == 0) ? '00:00:00' : gmdate("H:i:s", $totalTime);
echo '<span>' . $counter . '. ' . $row["userFirstname"] . ' ' . $lastnameInitial . ': ' . $totalTime . '</span>';
$counter++;
}
} else {
echo "Geen resultaten";
}
echo '</div>';
?>
</div>
</div>
</div>
</main>
</body>

</html>