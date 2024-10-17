<?php
session_start();
$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    <link rel="stylesheet" href="stylingfile/maindisplay.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
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

                <!-- Add Product Button -->
                <div class="button-container">
                    <button type="button" class="addnewOrder" onclick="window.location.href='inventoryaddeditem.php';">Add New Product</button>
                </div>
            </div>

            <div class="tableContainer">
                <table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Category</th> <!-- New Category Column -->
                        <th>Action</th>
                    </tr>
                    <?php
                    // Generate the inventory table
                    $sql = "SELECT id, productname, qty, price, category FROM inventory" . $searchQuery . $sortQuery;
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['productname'] . "</td>
                                <td>" . $row['qty'] . "</td>
                                <td>" . $row['price'] . "</td>
                                <td>" . $row['category'] . "</td>
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
                        echo "<tr><td colspan='6'>No products found</td></tr>"; // Adjusted colspan for the new column
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
