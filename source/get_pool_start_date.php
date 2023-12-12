<?php
require_once 'config.php';

$endDate = null;

$sql = "SELECT date_will_end FROM pools WHERE pool_status='active' LIMIT 1"; // Added LIMIT 1 for efficiency
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $endDate = $row["date_will_end"];
}

echo $endDate;

// Close the connection
$conn->close();
?>