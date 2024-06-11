<?php

include("../userincludes/userfunctions.inc.php");
include("../db/dbh.inc.php");

function fetchActivities($searchTerm = null)
{
    global $conn;

    if ($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt = $conn->prepare("SELECT 
a.activityId, 
a.assignmentId, 
a.userId, 
a.clockedIn, 
a.clockedBegin, 
a.clockedEnd, 
ROUND(a.totalTime / 3600, 2) AS totalTimeHours, 
a.deadline,
u.userFirstname,
u.userLastname,
u.userEmail,
ass.assignmentName,
ass.clientId,
c.companyName,
c.clientPhoneNumber,
c.clientFirstname,
c.clientLastname
FROM 
activity a
JOIN 
user u ON a.userId = u.userId
JOIN 
assignment ass ON a.assignmentId = ass.assignmentId
JOIN 
client c ON ass.clientId = c.clientId
WHERE 
u.userFirstname LIKE ? OR
u.userLastname LIKE ? OR
u.userEmail LIKE ? OR
c.companyName LIKE ? OR
ass.assignmentName LIKE ?");
        $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        return $conn->query("SELECT 
a.activityId, 
a.assignmentId, 
a.userId, 
a.clockedIn, 
a.clockedBegin, 
a.clockedEnd, 
ROUND(a.totalTime / 3600, 2) AS totalTimeHours, 
a.deadline,
u.userFirstname,
u.userLastname,
u.userEmail,
ass.assignmentName,
ass.clientId,
c.companyName,
c.clientPhoneNumber,
c.clientFirstname,
c.clientLastname
FROM 
activity a
JOIN 
user u ON a.userId = u.userId
JOIN 
assignment ass ON a.assignmentId = ass.assignmentId
JOIN 
client c ON ass.clientId = c.clientId");
    }
}
