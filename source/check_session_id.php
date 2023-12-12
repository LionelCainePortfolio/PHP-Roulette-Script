<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

$session_id = isset($_GET["session_id"]) ? $_GET["session_id"] : null;

if ($session_id === null) {
    echo "Data error.";
    exit;
}

$sqlCheckSessionId = "SELECT COUNT(*) as count FROM users WHERE session_id='$session_id'";
$resultCheckSessionId = $conn->query($sqlCheckSessionId);

if (!$resultCheckSessionId) {
    die("Error: " . $conn->error);
}

$rowCheckSessionId = $resultCheckSessionId->fetch_assoc();
$count = $rowCheckSessionId['count'];

if ($count == 0) {
    $sqlInsertSessionId = "INSERT INTO users (id, session_id, user_balance) VALUES ('','$session_id','2000')";
    $resultInsertSessionId = $conn->query($sqlInsertSessionId);
    if (!$resultInsertSessionId) {
        die("Error: " . $conn->error);
    }
}

echo $count;

$conn->close();
?>
