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
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No completed orders found</td></tr>";
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
