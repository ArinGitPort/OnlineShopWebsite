<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="maindisplay.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>

</head>

<body>

    <div class="maindisplayDiv">
        <div class="insideDisplayDiv">
            <div class="userMenuDiv">
            <input type="text" class="searchprodField" placeholder="Search Product">
            <button class="searchButton">Search</button>
            <button class="sortAlphaButton">Sort Alphabetically</button>
            </div>
        </div>
    </div>


    <?php include 'sidebar.php'; ?>



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