<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

$pool_id = isset($_GET["pool_id"]) ? $_GET["pool_id"] : null;

if ($pool_id === null) {
    echo "Data error.";
    exit;
}
$sqlGetJoinedMembers = "SELECT session_id, added_to_pool FROM pools_members WHERE pool_id ='$pool_id'";
$resultGetJoinedMembers = $conn->query($sqlGetJoinedMembers);

if (!$resultGetJoinedMembers) {
    die("Error: " . $conn->error);
}

$joinedMembers = array();

while ($row = $resultGetJoinedMembers->fetch_assoc()) {
    $joinedMembers[] = $row;
}

echo json_encode($joinedMembers);

$conn->close();
?>