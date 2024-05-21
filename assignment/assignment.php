<?php
include("../config.php");
include("../db/dbh.inc.php");
include("../userincludes/userfunctions.inc.php");

session_start();

if (isset($_POST['createassignment'])) {
    $assignmentName = $_POST['assignmentName'];
    $companyName = $_POST['companyName'];
    $deadline = $_POST['deadline'];
    $assignmentDescription = $_POST['assignmentDescription']; // Added this line

    if (empty($assignmentName) || empty($companyName) || empty($assignmentDescription)) { // Modified this line
        header("location: ../index.php?error=emptyfields");
        exit();
    }

    $sql = "SELECT clientId FROM client WHERE companyName = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employee/employee.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $companyName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $clientId = $row['clientId'];
        } else {
            header("location: ../employee/employee.php?error=companynotfound");
            exit();
        }
    }

    $sql = "INSERT INTO assignment (clientId, assignmentName, assignmentDescription) VALUES (?, ?, ?)"; // Modified this line
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employee/employee.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "iss", $clientId, $assignmentName, $assignmentDescription); // Modified this line
        mysqli_stmt_execute($stmt);
        $assignmentId = mysqli_insert_id($conn);

        $sql = "SELECT userId FROM user";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $userId = $row['userId'];

            $sql = "INSERT INTO activity (userId, assignmentId, clockedIn, clockedBegin, clockedEnd, selected, deadline) VALUES (?, ?, 0, NULL, NULL, 0, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../employee/employee.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "iis", $userId, $assignmentId, $deadline);
                mysqli_stmt_execute($stmt);
            }
        }
        header("location: ../employee/?success=assignmentcreated");
    }
}




if (isset($_POST['selectAssignment'])) {
    $assignmentId = $_POST['assignmentId'];
    $userId = $_SESSION['userId'];

    $sql = "SELECT COUNT(*) AS count FROM activity WHERE userId = ? AND selected = TRUE";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] >= 6) {
            header("location: index.php?error=maxassignments");
            exit();
        }
    }

    $sql = "UPDATE activity SET selected = TRUE WHERE assignmentId = ? AND userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "si", $assignmentId, $userId);
        mysqli_stmt_execute($stmt);
        header("location: index.php?success=assignmentselected");
    }
}


if (isset($_POST['deselectAssignment'])) {
    $assignmentId = $_POST['assignmentId'];
    $userId = $_SESSION['userId'];

    $sql = "SELECT COUNT(*) AS count FROM activity WHERE userId = ? AND selected = TRUE";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] <= 0) {
            header("location: index.php?error=noassignments");
            exit();
        }
    }

    $sql = "UPDATE activity SET selected = FALSE WHERE assignmentId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $assignmentId);
        mysqli_stmt_execute($stmt);
        header("location: index.php?success=assignmentdeselected");
    }
}

if (isset($_POST['clockIn'])) {
    $selectedAssignmentId = $_POST['assignmentId'];
    $currentUserId = $_SESSION['userId'];

    $sql = "SELECT selected FROM activity WHERE assignmentId = ? AND userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $selectedAssignmentId, $currentUserId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row['selected'] == FALSE) {
            header("location: index.php?error=assignmentnotselected");
            exit();
        }
    }

    $sql = "SELECT * FROM activity WHERE userId = ? AND clockedIn = 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $currentUserId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            header("location: index.php?error=alreadyclockedin");
            exit();
        }
    }

    $clockInTime = date('Y-m-d H:i:s');
    $sql = "UPDATE activity SET clockedIn = 1, clockedBegin = ? WHERE assignmentId = ? AND userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sis", $clockInTime, $selectedAssignmentId, $currentUserId);
        mysqli_stmt_execute($stmt);
        header("location: index.php?success=clockedin");
    }
}


if (isset($_POST['clockOut'])) {
    $selectedAssignmentId = $_POST['assignmentId'];
    $currentUserId = $_SESSION['userId'];

    $sql = "SELECT clockedBegin, totalTime FROM activity WHERE assignmentId = ? AND userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $selectedAssignmentId, $currentUserId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $clockedBegin = new DateTime($row['clockedBegin']);
        $totalTimeSoFarSeconds = $row['totalTime'] ? $row['totalTime'] : 0;
    }

    $clockOutTime = new DateTime();
    $sessionTime = $clockedBegin->diff($clockOutTime);

    $sessionSeconds = ((int)$sessionTime->format('%h')) * 3600 + ((int)$sessionTime->format('%i')) * 60 + ((int)$sessionTime->format('%s'));

    $totalTimeSeconds = $totalTimeSoFarSeconds + $sessionSeconds;

    $sql = "UPDATE activity SET clockedIn = 0, clockedEnd = ?, totalTime = ? WHERE assignmentId = ? AND userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "siii", $clockOutTime->format('Y-m-d H:i:s'), $totalTimeSeconds, $selectedAssignmentId, $currentUserId);
        mysqli_stmt_execute($stmt);
        header("location: index.php?success=clockedout");
    }
}
