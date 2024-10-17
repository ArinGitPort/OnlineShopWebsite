<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$dbUsername = "root"; // Database username
$dbPassword = ""; // Database password
$dbname = "logindb"; // Use your existing database name

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // Capture username input
    $email = trim($_POST['email']); // Capture email input
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash the password

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username may already exist. Please choose a different username.');</script>";
    } else {
        // Proceed to insert the new user
        $stmt = $conn->prepare("INSERT INTO userinfo (username, userpassword, useremail) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful! Redirecting to login page.');</script>";
            header("Location: login.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="stylingfile/register.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div class="registerBoxContainer">
        <div class="registerHeader"><h2>Register</h2></div>
        <form method="POST" action="">
            <div class="registerForm">
                <label>Username</label><br>
                <input type="text" name="username" class="usernameBox" required><br><br>

                <label>Password</label><br>
                <input type="password" name="password" class="passwordBox" required><br><br>

                <label>Email</label><br>
                <input type="email" name="email" required><br><br>
                
                <div class="registerButton">
                <input type="submit" value="Register" class="loginButton">
                <input type="button" value="Back" onclick="location.href='login.php';" class="loginButton">
                </div>
            </div>
        </form>
    </div>
</body>
</html>