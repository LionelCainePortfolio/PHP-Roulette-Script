<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

$session_id = isset($_GET["session_id"]) ? $_GET["session_id"] : null;

if ($session_id === null) {
    echo "Data error.";
    exit;
}

// Pobierz member_id dla danego session_id
$sqlGetMemberId = "SELECT id FROM users WHERE session_id='$session_id'";
$resultGetMemberId = $conn->query($sqlGetMemberId);

if (!$resultGetMemberId) {
    die("Error: " . $conn->error);
}

$rowGetMemberId = $resultGetMemberId->fetch_assoc();
$member_id = $rowGetMemberId['id'];

echo $member_id;

$conn->close();
?>