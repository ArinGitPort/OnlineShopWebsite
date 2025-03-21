<?php
// Database connection details
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "1234";
$dbname = "logindb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
