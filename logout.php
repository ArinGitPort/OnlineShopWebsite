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
            // Redirect to login.php if user clicks "OK"
            if (result) {
                window.location.href = "login.php";
            } else {
                // Redirect back to inventory or previous page if user clicks "Cancel"
                window.location.href = "inventory.php";
            }
        }
    </script>
</head>
<body onload="confirmLogout();"> <!-- Call the function on page load -->
</body>
</html>
