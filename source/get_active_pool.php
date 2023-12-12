<?php
require_once 'config.php';

$activePool = null;

$sql = "SELECT pool FROM pools WHERE pool_status = 'active' LIMIT 1"; // Added LIMIT 1 for efficiency
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $activePool = $row["pool"];
}

echo $activePool;

// Close the connection
$conn->close();
?>