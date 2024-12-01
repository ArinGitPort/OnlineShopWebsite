<?php
include 'sessionchecker.php';

$conn = new mysqli("localhost:3310", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search variables
$searchQuery = "";

// Check if the search form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchProduct'])) {
    $searchProduct = $conn->real_escape_string($_POST['searchProduct']);
    // Search in 'productname', 'id', and 'category'
    $searchQuery = " WHERE productname LIKE '%$searchProduct%' OR customername LIKE '%$searchProduct%' OR category LIKE '%$searchProduct%'";
}

// Fetch added items from inventory
$addedItemsSql = "SELECT * FROM addeditem ORDER BY id DESC"; // LIFO: latest first
$addedItemsResult = $conn->query($addedItemsSql);

// Fetch completed orders from orderhistory with search filters
$orderHistorySql = "SELECT * FROM orderhistory" . $searchQuery . " ORDER BY id DESC"; // LIFO: latest first
$orderHistoryResult = $conn->query($orderHistorySql);

// Fetch the latest order ID (top of the stack)
$latestOrderIdSql = "SELECT MAX(id) AS latestId FROM orderhistory";
$latestOrderIdResult = $conn->query($latestOrderIdSql);
$latestOrder = $latestOrderIdResult->fetch_assoc();
$latestOrderId = $latestOrder['latestId'];

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
        echo "<script>alert('Order reverted successfully!'); window.location.href = window.location.href;</script>";
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
                <form method="POST" action="">
                    <input type="text" name="searchProduct" class="searchprodField" placeholder="Search " value="<?php echo isset($searchProduct) ? htmlspecialchars($searchProduct) : ''; ?>">
                    <button type="submit" class="searchButton">Search</button>
                </form>
            </div>
            <div class="tableWrap">
                <table class="historyTable">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th >Category</th>
                        <th >Customer Name</th>
                        <th>Total Price</th>
                        <th>Date Completed</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($orderHistoryResult->num_rows > 0) {
                        while ($row = $orderHistoryResult->fetch_assoc()) {
                            $totalPrice = $row['qty'] * $row['price'];
                            echo "<tr>
                                <td>" . htmlspecialchars($row['productname']) . "</td>
                                <td>" . htmlspecialchars($row['qty']) . "</td>
                                <td>$" . number_format($row['price'], 2) . "</td>
                                <td>" . htmlspecialchars($row['category']) . "</td>
                                <td>" . htmlspecialchars($row['customername']) . "</td>
                                <td>" . '$' . number_format($totalPrice, 2) . "</td>
                                <td>" . htmlspecialchars($row['datecompleted']) . "</td>
                                <td>
                                    <form method='POST' style='display:inline;'>";

                            // Enable revert only for the latest (top of the stack) order
                            if ($row['id'] == $latestOrderId) {
                                // Allow reversion for the latest order
                                echo "<input type='hidden' name='revertOrderId' value='" . $row['id'] . "'>
                                      <input class='deletetableButton' type='submit' value='Revert' onclick='return confirm(\"Are you sure you want to revert this order?\");'>";
                            } else {
                                echo "<button class='deletetableButton disabledButton' disabled onclick='showRevertAlert()'>Revert</button>";
                            }

                            echo "</form>
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

    <style>
        .disabledButton {
            background-color: #d3d3d3;
            color: #808080;
            border: 1px solid #ccc;
            cursor: not-allowed;
        }
    </style>

</body>

<?php
$conn->close();
?>