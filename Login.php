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

// Redirect if already logged in
if (isset($_SESSION['username'])) {
  header("Location: home.php");
  exit();
}

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usernameInput = trim($_POST['usernameInp']); // Capture username input
  $passwordInput = trim($_POST['passwordInp']); // Capture password input

  // Use prepared statements to avoid SQL injection
  $stmt = $conn->prepare("SELECT userpassword FROM userinfo WHERE BINARY username = ?"); // Case-sensitive comparison using BINARY
  $stmt->bind_param("s", $usernameInput);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Use password_verify to check if the input password matches the hashed password
    if (password_verify($passwordInput, $row['userpassword'])) {
      $_SESSION['username'] = $usernameInput; // Store username in session
      header("Location: home.php"); // Redirect to dashboard
      exit();
    } else {
      echo "<script>alert('Invalid password!');</script>";
    }
  } else {
    echo "<script>alert('No user found!');</script>";
  }

  $stmt->close(); // Close statement
}

$conn->close(); // Close connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="stylingfile/loginstyle.css" />
  <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bunniwinkle Inventory</title>
</head>

<body>
  <div class="loginBoxContainer">
    <div class="iconDiv">
      <img src="imgBG/bunniwinkleIcon.jpg">
    </div>

    <form action="" method="POST">
      <div class="loginHeaderDiv">
        <h1 class="loginHeader">Login</h1>
        <hr>
      </div>
      <div class="loginInfoDiv">
        <input name="usernameInp" class="usernameBox" type="text" placeholder="Username" required><br>
        <input name="passwordInp" id="passwordInp" class="passwordBox" type="password" placeholder="Password"
          required><br>
        <!-- Show Password Checkbox -->
      </div>
      <!-- Forgot Password Link -->
      <div class="forgotShowPasswordDiv">
        <input type="checkbox" id="showPassword" onclick="togglePassword()" class="togglepass"> Show Password
        <a href="forgotpass.php" class="forgotPassLink">Forgot Password?</a>
      </div>
      <div class="loginButtonDiv">
        <button type="submit" class="loginButton">Log In</button>
        <a href="register.php" class="loginButton" style="text-decoration: none; color: inherit;">Register</a>
      </div>
    </form>
  </div>

  <!-- JavaScript to toggle password visibility -->
  <script>
    function togglePassword() {
      var passwordInput = document.getElementById("passwordInp");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }
  </script>
</body>

</html>