<?php
require_once 'config.php';
// Initialize $id to avoid potential issues
$id = null;

$sql = "SELECT id FROM pools WHERE pool_status = 'active' LIMIT 1"; // Added LIMIT 1 for efficiency
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row["id"];
}

echo $id;

// Close the connection
$conn->close();
?>