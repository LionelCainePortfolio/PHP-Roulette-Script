<?php

$servername = "mysql62.mydevil.net";
$username = "m1039_roulette";
$password = "AOm8ElGEggQPm2D";
$database = "m1039_roulette_demo";

// Tworzenie połączenia
$conn = new mysqli($servername, $username, $password, $database);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>