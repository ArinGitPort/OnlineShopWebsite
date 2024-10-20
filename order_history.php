<?php
include 'sessionchecker.php';

$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch added items from inventory
$addedItemsSql = "SELECT * FROM addeditem ORDER BY id DESC"; // LIFO: latest first
$addedItemsResult = $conn->query($addedItemsSql);

// Fetch completed orders from orderhistory
$orderHistorySql = "SELECT * FROM orderhistory ORDER BY id DESC"; // LIFO: latest first
$orderHistoryResult = $conn->query($orderHistorySql);

// Revert Order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['revertOrderId'])) {
    $orderId = intval($_POST['revertOrderId']);

    // Fetch order details
    $fetchOrderSql = "SELECT * FROM orderhistory WHERE id = ?";
    $stmt = $conn->prepare($fetchOrderSql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if ($order) {
        // Restore to productorder table
        $restoreItemSql = "INSERT INTO productorder (productname, qty, price, category, customername) VALUES (?, ?, ?, ?, ?)";
        $restoreStmt = $conn->prepare($restoreItemSql);
        $restoreStmt->bind_param("siiss", $order['productname'], $order['qty'], $order['price'], $order['category'], $order['customername']);
        $restoreStmt->execute();

        // Delete from orderhistory
        $deleteOrderSql = "DELETE FROM orderhistory WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteOrderSql);
        $deleteStmt->bind_param("i", $orderId);
        $deleteStmt->execute();

        // Optionally add success message here
        echo "<script>alert('Order reverted successfully!'); window.location.reload();</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/maindisplay.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="maindisplayDiv">
        <div class="insideTabelDisplayDiv">
            <div class="historylabelDiv">
                <h2 class="historyLabel">Order History</h2>
            </div>
            <div class="tableWrap">
                <table class="historyTable">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Customer Name</th>
                        <th>Date Completed</th>
                        <th>Action</th> <!-- Add Action Column -->
                    </tr>
                    <?php
                    if ($orderHistoryResult->num_rows > 0) {
                        while ($row = $orderHistoryResult->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['productname'] . "</td>
                                <td>" . $row['qty'] . "</td>
                                <td>" . $row['price'] . "</td>
                                <td>" . $row['category'] . "</td>
                                <td>" . $row['customername'] . "</td>
                                <td>" . $row['datecompleted'] . "</td>
                                <td>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='revertOrderId' value='" . $row['id'] . "'>
                                        <input class='deletetableButton' type='submit' value='Revert' onclick='return confirm(\"Are you sure you want to revert this order?\");'>
                                    </form>
                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No completed orders found</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>