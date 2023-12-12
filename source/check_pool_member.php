<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

$member_id = isset($_GET["session_id"]) ? $_GET["session_id"] : null;
$pool_id = isset($_GET["pool_id"]) ? $_GET["pool_id"] : null;
// Using prepared statements to prevent SQL injection

if ($member_id === null || $pool_id === null) {
    echo "Data error.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM pools_members WHERE pool_id = ? AND session_id = ?");
$stmt->bind_param("ii", $pool_id, $session_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if there is at least one row
if ($result->num_rows >= 1) {
    echo "yes";
} else {
    echo "no";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
