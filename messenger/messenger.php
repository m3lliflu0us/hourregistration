<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

include("../db/dbh.inc.php");

function getMessages($userId, $selectedUserId, $conn)
{
    $stmt = $conn->prepare("
SELECT m.*, u.userFirstname, u.userLastname 
FROM messages m
JOIN user u ON u.userId = m.senderId
WHERE (m.recipientId = ? AND m.senderId = ?) OR (m.recipientId = ? AND m.senderId = ?)
ORDER BY m.timestamp ASC
");
    $stmt->bind_param("iiii", $userId, $selectedUserId, $selectedUserId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $messages;
}

function sendMessage($senderId, $recipientId, $messageText, $conn)
{
    $stmt = $conn->prepare("INSERT INTO messages (senderId, recipientId, messageText) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $senderId, $recipientId, $messageText);
    $stmt->execute();
    $stmt->close();
}

function getEmployees($conn)
{
    $query = "SELECT userId, userFirstname, userLastname, userEmail, last_active FROM user";
    $result = $conn->query($query);

    if (!$result) {
        die("Error fetching employees: " . $conn->error);
    }

    $employees = $result->fetch_all(MYSQLI_ASSOC);
    if (count($employees) === 0) {
        return [];
    }
    return $employees;
}

function updateLastActive($userId, $conn)
{
    $stmt = $conn->prepare("UPDATE user SET last_active = NOW() WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

function deleteMessageForEveryone($messageId, $conn)
{
    $stmt = $conn->prepare("UPDATE messages SET deleted = TRUE WHERE messageId = ?");
    $stmt->bind_param("i", $messageId);
    $stmt->execute();
    $stmt->close();
}

// Function to edit a message
function editMessage($messageId, $newText, $conn)
{
    $stmt = $conn->prepare("UPDATE messages SET messageText = ? WHERE messageId = ?");
    $stmt->bind_param("si", $newText, $messageId);
    $stmt->execute();
    $stmt->close();
}

// Check if the 'action' POST variable is set
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $messageId = $_POST['messageId'];

    // Perform action based on the value of 'action'
    switch ($action) {
        case 'deleteForEveryone':
            deleteMessageForEveryone($messageId, $conn);
            break;
        case 'editMessage':
            $newText = $_POST['newText'];
            editMessage($messageId, $newText, $conn);
            break;
            // Add more cases for other actions like 'deleteForMe', etc.
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recipientId"]) && isset($_POST["message"])) {
    if (isset($_SESSION["userId"])) {
        $senderId = $_SESSION["userId"];
        $recipientId = $_POST["recipientId"];
        $messageText = $_POST["message"];
        sendMessage($senderId, $recipientId, $messageText, $conn);
        updateLastActive($senderId, $conn);
        header("Location: index.php?chat=" . urlencode($recipientId) . "&success=1");
        exit();
    } else {
        header("Location: index.php?error");
        exit();
    }
}
