<?php
session_start();
$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new item to the inventory and addeditem tables
if (isset($_POST['addItem'])) {
    $newProduct = $conn->real_escape_string($_POST['newProduct']);
    $newQty = (int)$_POST['newQty'];
    $newPrice = (float)$_POST['newPrice'];

    // Insert into the inventory table
    $sql = "INSERT INTO inventory (productname, qty, price) VALUES ('$newProduct', $newQty, $newPrice)";
    if ($conn->query($sql) === TRUE) {
        // Get the last inserted ID from the inventory table
        $lastInsertedID = $conn->insert_id;

        // Insert the new product into the addeditem table
        $sqlAdded = "INSERT INTO addeditem (id, productname, qty, price) VALUES ($lastInsertedID, '$newProduct', $newQty, $newPrice)";
        
        if ($conn->query($sqlAdded) === TRUE) {
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error adding to addeditem: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Soft delete and move to deleteditem table
if (isset($_POST['delete'])) {
    $deleteID = $_POST['delete_id'];

    $sql = "INSERT INTO deleteditem (id, deletedproduct) SELECT id, productname FROM inventory WHERE id=$deleteID";
    $conn->query($sql);
    $sql = "DELETE FROM inventory WHERE id=$deleteID";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Item deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting item: " . $conn->error . "');</script>";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Search functionality
$searchQuery = "";
if (isset($_POST['searchProduct'])) {
    $searchProduct = addslashes($_POST['searchProduct']);
    $searchQuery = " WHERE productname LIKE '%$searchProduct%'";
}


// Sort Alphabetically
$sortQuery = "";
if (isset($_POST['sortAlpha'])) {
    $sortQuery = " ORDER BY productname ASC";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="maindisplay.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="maindisplayDiv">
        <div class="insideDisplayDiv">
            <div class="userMenuDiv">
                <!-- Search and Sort Alphabetically Form -->
                <form method="POST" action="">
                    <input type="text" name="searchProduct" class="searchprodField" placeholder="Search Product">
                    <button type="submit" class="searchButton">Search</button>
                    <button type="submit" name="sortAlpha" class="sortAlphaButton">Sort Alphabetically</button>
                </form>

                <!-- Add Item Form -->
                <form method="POST" action="">
                    <div class="addinputField">
                        <input class="prodnameField" type="text" name="newProduct" placeholder="Product Name" required>
                        <input class="prodqtyField" type="number" name="newQty" placeholder="Quantity" required>
                        <input class="prodpriceField" type="number" step="0.01" name="newPrice" placeholder="Price" required>
                        <button type="submit" name="addItem" class="addButton">Add Item</button>
                    </div>
                </form>
            </div>

            <div class="tableContainer">
                <table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    // Generate the inventory table
                    $sql = "SELECT id, productname, qty, price FROM inventory" . $searchQuery . $sortQuery;
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['productname'] . "</td>
                                <td>" . $row['qty'] . "</td>
                                <td>" . $row['price'] . "</td>
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
                        echo "<tr><td colspan='5'>No products found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this item?');
        }
    </script>

</body>

</html>
