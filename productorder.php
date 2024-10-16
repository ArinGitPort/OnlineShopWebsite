<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="maindisplay.css">
    <link rel="stylesheet" href="additem.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Orders</title>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="maindisplayDiv">
        <div class="insideDisplayDiv">
            <div class="userMenuDiv">
                <!-- Search and Sort Alphabetically Form -->
                <form method="POST" action="">
                    <input type="text" name="searchProduct" class="ordersearchProduct"
                        placeholder="Search Product or Customer">
                    <button type="submit" class="searchButton">Search</button>
                    <button type="submit" name="sortAlpha" class="sortAlphaButton">Sort Alphabetically</button>
                </form>

                <!-- Link to Add Order Form -->
                <button class="addItemButton" onclick="window.location.href='additem.php'">Add New Order</button>
            </div>

            <div class="tableContainer">
                <table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Customer Name</th>
                        <th>Total Price</th> <!-- New Total Price Column -->
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    // Generate the orders table
                    $conn = new mysqli("localhost", "root", "", "logindb");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Handle search and sorting
                    $searchQuery = "";
                    if (isset($_POST['searchProduct'])) {
                        $searchProduct = addslashes($_POST['searchProduct']);
                        $searchQuery = " WHERE productname LIKE '%$searchProduct%' OR customername LIKE '%$searchProduct%'";
                    }

                    $sortQuery = "";
                    if (isset($_POST['sortAlpha'])) {
                        $sortQuery = " ORDER BY productname ASC";
                    }

                    // Fetch items with the search and sorting
                    $sql = "SELECT id, productname, qty, price, category, customername, dateadded FROM productorder" . $searchQuery . $sortQuery;
                    $result = $conn->query($sql);

                    // Check if items exist and display them
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Calculate total price for the row
                            $totalPrice = $row['qty'] * $row['price']; 
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['productname'] . "</td>
                                <td>" . $row['qty'] . "</td>
                                <td>" . $row['price'] . "</td>
                                <td>" . $row['category'] . "</td>
                                <td>" . $row['customername'] . "</td>
                                <td>" . number_format($totalPrice, 2) . "</td> <!-- Display Total Price -->
                                <td>" . $row['dateadded'] . "</td>
                                <td>
                                    <form method='POST' action='' onsubmit='return confirmDelete();'>
                                        <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                        <button class='deletetableButton' type='submit' name='delete'>Delete</button>
                                    </form>
                                    <form method='GET' action='edititem.php'>
                                        <input type='hidden' name='edit_id' value='" . $row['id'] . "'>
                                        <button class='edittableButton' type='submit' name='edit'>Edit</button>
                                    </form>
                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No orders found</td></tr>"; // Adjusted colspan for the new column
                    }

                    $conn->close();
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this order?');
        }
    </script>

</body>

</html>
