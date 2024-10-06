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

            <!-- Start of the Table to Display the Inventory -->
            <div class="tableDiv">
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Database connection
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "logindb";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // SQL query to fetch data from the inventory table
                        $sql = "SELECT id, productname, qty, price FROM inventory";
                        $result = $conn->query($sql);

                        // If there are results, display them in the table
                        if ($result->num_rows > 0) {
                            // Fetch each row from the result set
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["productname"] . "</td>";
                                echo "<td>" . $row["qty"] . "</td>";
                                echo "<td>" . $row["price"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No products found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- End of Table -->
        </div>
    </div>

    <?php include 'sidebar.php'; ?>

</body>

</html>
