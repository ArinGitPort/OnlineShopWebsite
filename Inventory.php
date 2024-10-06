<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="sidebarstyle.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>

</head>

<body>

    <div class="dashboardContainer">
        <div class="dashboardProfile">
            <div>
                <h1 class="inventoryLabel">INVENTORY</h1>
            </div>
            <div><img class="userIcon" src="bunniwinkleIcon.jpg" alt=""></div>
            <div>
                <h3 style="font-family: Arial, Helvetica, sans-serif;" class="usernameLabel">Bunniwinkle</h3>
            </div>
        </div>

        <div class="sidebarMenuContainer">
            <ul class="listDashboard">
                <li>
                    <div><a href="" class="menuDashboard">INVENTORY</a></div>
                </li>
                <li>
                    <div><a href="" class="menuDashboard">HOME</a></div>
                </li>
                <li>
                    <div><a href="" class="menuDashboard">LOG-OUT</a></div>
                </li>
            </ul>
        </div>

    </div>



    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "logindb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch data from the items table
    $sql = "SELECT id, productname, qty, price FROM inventory";
    $result = $conn->query($sql);
    ?>

</body>

</html>