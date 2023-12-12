<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "config.php";
file_put_contents("debug_log.txt", print_r($_POST, true)); 
$member_id = isset($_POST["member_id"]) ? $_POST["member_id"] : null;
$session_id = isset($_POST["session_id"]) ? $_POST["session_id"] : null;
$pool_id = isset($_POST["pool_id"]) ? $_POST["pool_id"] : null;
$pool = isset($_POST["pool"]) ? $_POST["pool"] : null;
$date = date("Y-m-d");
$date_now = date("m/d/Y h:i:s a", time());
$user_balance;
$user_balance2;
$added_to_pool_db;
$added_to_pool_db2;
if ($member_id === null || $pool_id === null || $pool === null) {
    echo "Data error.";
    exit();
}

// Check if the pool members record exists
$sqlCheckMember = "SELECT COUNT(*) as count FROM pools_members WHERE pool_id='$pool_id' AND session_id='$session_id'";
$resultCheckMember = $conn->query($sqlCheckMember);

// Check if the SQL query was executed successfully
if (!$resultCheckMember) {
    die("Error: " . $conn->error);
}
// Get the number of rows from the query result
$rowCheckMember = $resultCheckMember->fetch_assoc();
$rowsCheckMember = $rowCheckMember["count"];

if ($rowsCheckMember >= 1) {
    $sqlFetcheUser = "SELECT * FROM users WHERE session_id='$session_id'";
    $resultFetchUser = $conn->query($sqlFetcheUser);

    while ($rowUpdateUser = $resultFetchUser->fetch_assoc()) {
        $user_balance = $rowUpdateUser["user_balance"];
        if ($user_balance > $pool) {
            $sqlUpdatePool =
                "UPDATE pools SET date_last_update=NOW(), pool=pool+'" .
                $pool .
                "' WHERE id='" .
                $pool_id .
                "'";
            $resultUpdatePools = $conn->query($sqlUpdatePool);

            $sqlUpdateUserBalance =
                "UPDATE users SET user_balance=user_balance-'" .
                $pool .
                "' WHERE session_id='" .
                $session_id .
                "'";
            $resultUpdateUserBalance = $conn->query($sqlUpdateUserBalance);

            $sqlUpdatePoolMembers =
                "UPDATE pools_members SET added_to_pool=added_to_pool+'" .
                (int) $pool .
                "' WHERE session_id='" .
                $session_id .
                "' AND pool_id='" .
                $pool_id .
                "'";
            $resultUpdatePoolMembers = $conn->query($sqlUpdatePoolMembers);
        }
    }
} else {
    $sqlInsertPoolMember = "INSERT INTO pools_members (pool_id, member_id, session_id, added_to_pool, added_date) VALUES ('$pool_id', '$member_id','$session_id', '$pool', NOW())";
    $resultInsertPoolMembers = $conn->query($sqlInsertPoolMember);

    $sqlFetcheUser = "SELECT * FROM users WHERE session_id='$session_id'";
    $resultFetchUser = $conn->query($sqlFetcheUser);

    while ($rowUpdateUser = $resultFetchUser->fetch_assoc()) {
        $user_balance = $rowUpdateUser["user_balance"];
        if ($user_balance > $pool) {
            $sqlCheckPool = "SELECT * FROM pools WHERE id='$pool_id'";
            $rowsCheckPool = mysqli_num_rows($conn->query($sqlCheckPool));

            if ($rowsCheckPool == 1) {
                $sqlUpdatePool =
                    "UPDATE pools SET date_last_update=NOW(), pool_members=pool_members+1, pool=pool+'" .
                    $pool .
                    "' WHERE id='" .
                    $pool_id .
                    "'";
                $resultUpdatePool = $conn->query($sqlUpdatePool);

                $sqlUpdateUserBalance =
                    "UPDATE users SET user_balance=user_balance-'" .
                    $pool .
                    "' WHERE session_id='" .
                    $session_id .
                    "'";
                $resultUpdateUserBalance = $conn->query($sqlUpdateUserBalance);
            }
        }
    }
}

$conn->close();
?>
