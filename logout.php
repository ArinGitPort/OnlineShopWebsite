<?php
session_start(); // Start the session

// Check if the user confirmed the logout
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    // If confirmed, destroy the session and redirect to login
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php");
    exit();
} elseif (isset($_GET['confirm']) && $_GET['confirm'] == 'no') {
    // If the user clicked "Cancel", redirect back to the inventory page
    header("Location: inventory.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script>
        // Function to confirm logout
        function confirmLogout() {
            // Display confirmation dialog
            var result = confirm("Are you sure you want to logout?");
            // If confirmed, go to logout.php with the 'confirm=yes' parameter
            if (result) {
                window.location.href = "logout.php?confirm=yes";
            } else {
                // If canceled, go back to inventory.php with 'confirm=no' parameter
                window.location.href = "logout.php?confirm=no";
            }
        }
    </script>
</head>
<body onload="confirmLogout();"> <!-- Call the function on page load -->
</body>
</html>
