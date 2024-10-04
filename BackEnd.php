<?php
$servername = "localhost";
$username = "root"; // default XAMPP user
$password = ""; // no password by default
$dbname = "shoppingdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = htmlspecialchars($_POST['item']);
    $sql = "INSERT INTO items (name) VALUES ('$item')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Item added: " . $item;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
