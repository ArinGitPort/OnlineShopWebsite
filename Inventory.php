<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="inventorystyle.css">
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
                <div><a href="" class="menuDashboard">LOG-OUT</a></div>
                </li>
            </ul>
        </div>

    </div>



    <?php
    $servername = "localhost";
    $username = "root"; // default XAMPP user
    $password = ""; // no password by default
    $dbname = "inventorydb";

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

</body>

</html>