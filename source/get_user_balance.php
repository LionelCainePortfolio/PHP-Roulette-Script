<?php
require_once 'config.php';
file_put_contents('debug_log.txt', print_r($_GET, true)); // Dodaj tę linię, aby zobaczyć zawartość tablicy $_POST

$session_id = isset($_GET["session_id"]) ? $_GET["session_id"] : null;
if ($session_id === null) {
    echo "Data error.";
    exit;
}

$sql = "SELECT user_balance FROM users WHERE session_id='$session_id' LIMIT 1"; // Added LIMIT 1 for efficiency
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_balance = $row["user_balance"];
    echo $user_balance;
}


// Close the connection
$conn->close();
?>