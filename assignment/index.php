<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

$currentPage = 'assignment';


include("../config.php");
include("../userincludes/userfunctions.inc.php");
include("../db/dbh.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
    <title>Opdrachten | Gilde DevOps</title>
    <link rel="stylesheet" href="assignment.css">
    <link rel="stylesheet" href="../assets/layout.css">
    <link rel="stylesheet" href="../assets/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <?php include("../assets/navbar.php") ?>
        <div class="dashboard-wrapper">
            <div class="dashboard-window">

                <div class="assignment-container">
                    <div class="mainassignment-wrapper">
                        <div class="info-wrapper">
                            <span class="title">Jouw geselecteerde opdrachten</span>
                        </div>
                        <?php
                        $userId = $_SESSION['userId'];
                        $sql = "SELECT COUNT(*) AS count FROM activity WHERE userId = ? AND selected = TRUE";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "SQL error";
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $userId);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $row = mysqli_fetch_assoc($result);
                            if (isset($row['count']) && $row['count'] == 0) {
                                echo '<div class="mainassignment-item">';
                                echo '<div class="noassignment"><span>Nog geen opdrachten geselecteerd</span></div>';
                                echo '</div>';
                            } else {
                                $sql = "SELECT activity.*, assignment.assignmentName, client.clientId, client.clientFirstname, client.clientLastname FROM activity INNER JOIN assignment ON activity.assignmentId = assignment.assignmentId INNER JOIN client ON assignment.clientId = client.clientId WHERE activity.userId = ? AND activity.selected = TRUE";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "SQL error";
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $userId);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<div class="mainassignment-item">';
                                        echo '<span class="mainassignment-title">' . htmlspecialchars($row['assignmentName']) . '</span>';
                                        echo '<div class="clock-wrapper">';
                                        echo '<div class="clock-left">';
                                        echo '<span class="client-name">Klantnaam: ' . htmlspecialchars($row['clientFirstname']) . ' ' . htmlspecialchars($row['clientLastname']) . '</span>';
                                        echo '<span class="client-id">Klant ID: ' . htmlspecialchars($row['clientId']) . '</span>';
                                        echo '<span class="assignment-id">Opdracht ID: ' . htmlspecialchars($row['assignmentId']) . '</span>';
                                        if ($row['deadline'] !== NULL) {
                                            echo '<span class="deadline">Deadline: ' . date('d/m/Y', strtotime($row['deadline'])) . '</span>';
                                        } else {
                                            echo '<span class="deadline">Geen deadline aangegeven</span>';
                                        }

                                        echo '</div>';
                                        echo '<form class="clock-form" action="assignment.php" method="post">';
                                        echo '<input type="hidden" name="assignmentId" value="' . htmlspecialchars($row['assignmentId']) . '">';

                                        if ($row['clockedIn'] == 1) {
                                            echo '<input class="clock-button" type="submit" name="clockOut" value="Klok uit">';
                                            $buttonClass = 'assignment-button-disabled';
                                            $tooltipText = 'Klok eerst uit';
                                            echo '<button class="' . $buttonClass . '" type="submit" name="deselectAssignment" disabled>Deselecteer opdracht<span class="tooltip">' . $tooltipText . '</span></button>';
                                        } else {
                                            echo '<button class="clock-button" name="clockIn">Klok in<span class="tooltip">Klok eerst uit</span></button>';
                                            echo '<input class="assignment-button deselect" type="submit" name="deselectAssignment" value="Deselecteer opdracht">';
                                        }

                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="assignment-wrapper">
                        <form class="search-wrapper" method="post">
                            <div class="info-wrapper title-margin">
                                <span>Kies een opdracht</span>
                            </div>
                            <div class="search-container">
                                <div class="search">
                                    <input type="text" name="searchAssignment" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="searchAssignment">Zoek naar opdracht naam of ID</label>
                                </div>
                            </div>
                        </form>

                        <div class="assignment-item-wrapper">
                            <?php
                            $inputText = $_POST['searchAssignment'] ?? '';
                            $highlightId = $_GET['highlight'] ?? '';

                            if (!empty($inputText)) {
                                $sql = "SELECT assignment.*, client.clientId FROM assignment INNER JOIN client ON assignment.clientId = client.clientId WHERE assignment.assignmentName LIKE ? OR assignment.assignmentId LIKE ?";
                                $stmt = $conn->prepare($sql);
                                $param = "%{$inputText}%";
                                $stmt->bind_param("ss", $param, $param);
                            } else {
                                $sql = "SELECT assignment.*, client.clientId FROM assignment INNER JOIN client ON assignment.clientId = client.clientId";
                                $stmt = $conn->prepare($sql);
                            }

                            if (!$stmt) {
                                echo "SQL error: " . $conn->error;
                            } else {
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $highlightClass = ($row['assignmentId'] == $highlightId) ? 'highlight' : '';

                                    echo '<div class="assignment-item ' . $highlightClass . '">';
                                    echo '<span class="assignment-title">' . htmlspecialchars($row['assignmentName']) . '</span>';
                                    echo '<div class="bottom">';
                                    echo '<div class="bottom-left">';
                                    echo '<span class="client-id">Klant ID: ' . htmlspecialchars($row['clientId']) . '</span>';
                                    echo '<span class="assignment-id">Opdracht ID: ' . htmlspecialchars($row['assignmentId']) . '</span>';
                                    echo '</div>';
                                    echo '<form action="assignment.php" method="post">';
                                    echo '<input type="hidden" name="assignmentId" value="' . htmlspecialchars($row['assignmentId']) . '">';

                                    $sql = "SELECT * FROM activity WHERE userId = ? AND assignmentId = ? AND selected = TRUE";
                                    $stmt2 = $conn->prepare($sql);
                                    if (!$stmt2) {
                                        echo "SQL error";
                                    } else {
                                        $stmt2->bind_param("ss", $_SESSION['userId'], $row['assignmentId']);
                                        $stmt2->execute();
                                        $result2 = $stmt2->get_result();
                                        $row2 = $result2->fetch_assoc();

                                        $sql = "SELECT COUNT(*) AS count FROM activity WHERE userId = ? AND selected = TRUE";
                                        $stmt3 = $conn->prepare($sql);
                                        if (!$stmt3) {
                                            echo "SQL error";
                                        } else {
                                            $stmt3->bind_param("s", $_SESSION['userId']);
                                            $stmt3->execute();
                                            $result3 = $stmt3->get_result();
                                            $row3 = $result3->fetch_assoc();

                                            $buttonClass = $row2 || $row3['count'] >= 6 ? 'assignment-button-disabled' : 'assignment-button';
                                            $tooltipText = $row2 ? 'Deze opdracht is al geselecteerd' : ($row3['count'] >= 6 ? 'Deselecteer eerst een opdracht' : 'Selecteer opdracht');
                                            echo '<button class="' . $buttonClass . '" type="submit" name="selectAssignment" ' . ($row2 || $row3['count'] >= 6 ? 'disabled' : '') . '>Selecteer opdracht<span class="tooltip">' . $tooltipText . '</span></button>';
                                        }
                                    }
                                    echo '</form>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>
</body>

</html>