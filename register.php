<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username may already exist. Please choose a different username.');</script>";
    } else {
        // Insert new user into database
        $stmt = $conn->prepare("INSERT INTO userinfo (username, userpassword, useremail) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);

        if ($stmt->execute()) {
            // Clear any active session before redirecting to login
            session_unset(); // Unset all session variables
            session_destroy(); // Destroy the session

            echo "<script>
                    alert('Registration Successful! You will be redirected to the login page.');
                    window.location.href = 'login.php'; 
                  </script>";
            exit();
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
    <style>
        .tooltip {
            color: red;
            /* Tooltip text color */
            font-size: 12px;
            /* Font size */
            margin-left: 5px;
            /* Spacing from the input */
        }
    </style>
</head>

<body>
    <div class="registerBoxContainer">
        <div class="registerHeader">
            <h2>Register</h2>
        </div>
        <form method="POST" action="">
            <div class="registerForm">
                <label>Username</label><br>
                <input type="text" name="username" class="usernameBox" placeholder="Username" required><br><br>

                <label>Password</label><br>
                <input type="password" name="password" id="password" class="passwordBox" placeholder="Password"
                    required><br>

                <div><input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password<br><br></div>


                <label>Email</label><br>
                <input type="email" name="email" class="emailbox" placeholder="Email" required
                    onfocus="showTooltip(this)" onblur="hideTooltip(this)">

                
                
                <span class="tooltip" style="display: none; margin-top:10px;">Please remember your email for
                    recovery!</span><br><br>

                <div class="registerButton">
                    <input type="submit" value="Register" class="loginButton">
                    <input type="button" value="Back" onclick="location.href='login.php';" class="loginButton">
                </div>
            </div>
        </form>
    </div>

    <script>
        // Show tooltip on focus or hover
        function showTooltip(input) {
            const tooltip = input.nextElementSibling; // Get the next sibling (the span)
            tooltip.style.display = "inline"; // Show the tooltip
        }

        // Hide tooltip when focus is lost
        function hideTooltip(input) {
            const tooltip = input.nextElementSibling; // Get the next sibling (the span)
            tooltip.style.display = "none"; // Hide the tooltip
        }

        // Toggle password visibility
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var showPasswordCheckbox = document.getElementById("showPassword");

            // Toggle the type attribute
            if (showPasswordCheckbox.checked) {
                passwordField.type = "text"; // Show password
            } else {
                passwordField.type = "password"; // Hide password
            }
        }

        // Client-side validation: Prevent spaces in the username
        document.querySelector('form').addEventListener('submit', function (e) {
            var username = document.querySelector('input[name="username"]').value;

            // Check if the username contains any spaces
            if (/\s/.test(username)) {
                e.preventDefault(); // Prevent form submission
                alert('Username should not contain spaces. Please enter a valid username.');
            }
        });
    </script>
</body>

</html>