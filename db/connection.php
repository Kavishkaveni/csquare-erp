<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment"; // make sure this matches the database name in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
