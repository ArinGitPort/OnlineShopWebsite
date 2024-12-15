<?php
include 'sessionchecker.php';


// Database connection
$servername = "localhost";
$dbUsername = "root"; // Database username
$dbPassword = "1234"; // Database password
$dbname = "logindb"; // Use your existing database name

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process forgot password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailInput = trim($_POST['emailInp']); // Capture email input
    $newPasswordInput = trim($_POST['newPasswordInp']); // Capture new password input

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE useremail = ?");
    $stmt->bind_param("s", $emailInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the email exists, update the password in the database
        $hashedPassword = password_hash($newPasswordInput, PASSWORD_DEFAULT); // Hash the new password
        $updateStmt = $conn->prepare("UPDATE userinfo SET userpassword = ? WHERE useremail = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $emailInput);
        $updateStmt->execute();

        echo "<script>alert('Your password has been successfully updated!');</script>";
    } else {
        echo "<script>alert('Email not found!');</script>";
    }

    $stmt->close(); // Close statement
    $updateStmt->close(); // Close update statement
}

$conn->close(); // Close connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="stylingfile/forgotpass.css" />
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
</head>

<body>
  <div class="forgotPasswordBoxContainer">
    <div class="iconDiv">
      <img src="imgBG/bunniwinkleIcon.jpg">
    </div>

    <form action="" method="POST">
      <div class="forgotPasswordHeaderDiv">
        <h1 class="forgotPasswordHeader">Forgot Password</h1>
        <hr>
      </div>
      <div class="forgotPasswordInfoDiv">
        <input name="emailInp" class="emailBox" type="email" placeholder="Enter your email" required><br>
        <input name="newPasswordInp" class="newPasswordBox" type="password" placeholder="Enter new password" required><br>
      </div>
      <div class="showpassDiv">
      <input class="showpass" type="checkbox" id="showNewPassword" onclick="toggleNewPassword()"> Show Password
      </div>
      <div class="forgotPasswordButtonDiv">
        <button type="submit" class="forgotPasswordButton">Submit</button>
        <a href="login.php" class="forgotPasswordButton" style="text-decoration: none; color: inherit">Back to Login</a>
      </div>
    </form>
  </div>

  <!-- JavaScript to toggle password visibility -->
  <script>
    function toggleNewPassword() {
      var newPasswordInput = document.querySelector(".newPasswordBox");
      if (newPasswordInput.type === "password") {
        newPasswordInput.type = "text";
      } else {
        newPasswordInput.type = "password";
      }
    }
  </script>
</body>
</html>
