<?php
include 'sessionchecker.php';
include 'db_connection.php';

// Handle search and sorting
$searchQuery = "";
if (isset($_POST['searchProduct'])) {
    $searchProduct = addslashes($_POST['searchProduct']);
    $searchQuery = " WHERE productname LIKE '%$searchProduct%' OR customername LIKE '%$searchProduct%' OR id LIKE '%$searchProduct%'";
}

$sortQuery = "";
if (isset($_POST['sortAlpha'])) {
    $sortQuery = " ORDER BY productname ASC";
} elseif (isset($_POST['sortCategory'])) {
    $sortQuery = " ORDER BY category ASC";
}

// Fetch items with the search and sorting
$sql = "SELECT id, productname, qty, price, category, customername, dateadded FROM productorder" . $searchQuery . $sortQuery;
$result = $conn->query($sql);

// Count the total number of products in the table (no filter applied)
$totalCountQuery = "SELECT COUNT(*) AS total FROM productorder";
$totalCountResult = $conn->query($totalCountQuery);
$totalCountRow = $totalCountResult->fetch_assoc();
$totalOrders = $totalCountRow['total'];

// Handle deletion (Complete Order)
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete_id']);

    // Fetch the order details before deletion
    $orderSql = "SELECT * FROM productorder WHERE id = $delete_id";
    $orderResult = $conn->query($orderSql);

    if ($orderResult && $orderResult->num_rows > 0) {
        $order = $orderResult->fetch_assoc();

        // Insert into orderhistory table
        $insertHistorySql = "INSERT INTO orderhistory (productname, qty, price, category, customername, datecompleted) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertHistorySql);
        $stmt->bind_param("sidsss", $order['productname'], $order['qty'], $order['price'], $order['category'], $order['customername'], $order['datecompleted']);

        if ($stmt->execute()) {
            // Now delete the order from productorder
            $deleteSql = "DELETE FROM productorder WHERE id = $delete_id";
            if ($conn->query($deleteSql) === TRUE) {
                // Resequence IDs after deletion
                $resequenceSql = "SET @count = 0;
                                  UPDATE productorder SET id = @count:= @count + 1;
                                  ALTER TABLE productorder AUTO_INCREMENT = 1;";
                $conn->multi_query($resequenceSql);
                echo "<script>window.location.href = window.location.href;</script>";
            } else {
                echo "<script>alert('Error deleting order: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Error inserting into order history: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Order not found.');</script>";
    }
}


// Handle order cancellation (Restock Product)
if (isset($_POST['cancel'])) {
    $cancel_id = intval($_POST['cancel_id']);

    // Fetch the product details from productorder
    $orderSql = "SELECT productname, qty FROM productorder WHERE id = $cancel_id";
    $orderResult = $conn->query($orderSql);

    if ($orderResult && $orderResult->num_rows > 0) {
        $order = $orderResult->fetch_assoc();
        $productName = $order['productname'];
        $qtyToRestore = $order['qty'];

        // Update the inventory table to increase the quantity
        $updateInventorySql = "UPDATE inventory SET qty = qty + ? WHERE productname = ?";
        $stmt = $conn->prepare($updateInventorySql);
        $stmt->bind_param("is", $qtyToRestore, $productName);

        if ($stmt->execute()) {
            // Now delete the order from productorder
            $deleteSql = "DELETE FROM productorder WHERE id = $cancel_id";
            if ($conn->query($deleteSql) === TRUE) {
                // Resequence IDs after cancellation
                $resequenceSql = "SET @count = 0;
                                  UPDATE productorder SET id = @count:= @count + 1;
                                  ALTER TABLE productorder AUTO_INCREMENT = 1;";
                $conn->multi_query($resequenceSql);
                echo "<script>window.location.href = window.location.href;</script>";
            } else {
                echo "<script>alert('Error canceling order: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Error updating inventory: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Order not found.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/maindisplay.css">
    <link rel="stylesheet" href="stylingfile/additem.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
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
                    <span class="orderCount">Total Orders: <?php echo $totalOrders; ?></span>
                    <input type="text" name="searchProduct" class="ordersearchProduct"
                        placeholder="Search Product or Customer">
                    <button type="submit" class="searchButton">Search</button>
                    <button type="submit" name="sortAlpha" class="sortAlphaButton">Sort Alphabetically</button>
                    <button type="submit" name="sortCategory" class="sortAlphaButton">Sort by Category</button>
                </form>

                <!-- Link to Add Order Form -->
                <button class="addnewOrder" onclick="window.location.href='addorder.php'">Add New Order</button>
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
                        <th>Total Price</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $totalPrice = $row['qty'] * $row['price'];
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['productname'] . "</td>
                                <td>" . $row['qty'] . "</td>
                                <td>$" . number_format($row['price'], 2) . "</td>
                                <td>" . $row['category'] . "</td>
                                <td>" . $row['customername'] . "</td>
                                <td>" . '$' . number_format($totalPrice, 2) . "</td>
                                <td>" . $row['dateadded'] . "</td>
                                <td>
                                    <form method='POST' action='' onsubmit='return confirmDelete();'>
                                        <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                        <button class='deletetableButton' type='submit' name='delete'>Complete Order</button>
                                    </form>
                                    <form method='POST' action='' onsubmit='return confirmCancel();'>
                                        <input type='hidden' name='cancel_id' value='" . $row['id'] . "'>
                                        <button class='deletetableButton' type='submit' name='cancel'>Cancel Order</button>
                                    </form>
                                    <form method='GET' action='editorder.php'>
                                        <input type='hidden' name='edit_id' value='" . $row['id'] . "'>
                                        <button class='edittableButton' type='submit' name='edit'>Edit Order</button>
                                    </form>
                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No orders found</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to mark this order as completed?');
        }

        function confirmCancel() {
            return confirm('Are you sure you want to cancel this order?');
        }
    </script>

</body>

</html>