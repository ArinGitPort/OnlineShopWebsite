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
      <img src="bunniwinkleIcon.jpg">
    </div>

    <form action="login.php" method="POST">
      <div class="loginHeaderDiv">
        <h1 class="loginHeader">Login</h1>
        <hr>
      </div>
      <div class="loginInfoDiv">
        <input name="usernameInp" class="usernameBox" type="text" placeholder="Username"><br>
        <input name="passwordInp" class="passwordBox" type="password" placeholder="Password">
      </div>
      <div class="loginButtonDiv">
        <button class="loginButton" onclick="loginUser()">Log In</button>
      </div>
    </form>
  </div>



  <?php
  // Database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "logindb";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Process login
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['usernameInp']);
    $password = htmlspecialchars($_POST['passwordInp']);

    // Check user credentials
    $sql = "SELECT * FROM userinfo WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      header("Location: home.php");
    } else {
      echo "<script>alert('Invalid username or password.');</script>";
    }

  }

  $conn->close();
  ?>


  <script>


    function loginUser() {
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;

      if (!username || !password) {
        alert('Please fill in both fields.');
        return false; // Prevent form submission
      }
      return true; // Allow form submission
      
    }
  </script>

</body>

</html>