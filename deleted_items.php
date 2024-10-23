<?php
include 'sessionchecker.php';
$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch deleted items from deleteditem
$deletedItemsSql = "SELECT * FROM deleteditem ORDER BY id DESC"; // LIFO: latest first
$deletedItemsResult = $conn->query($deletedItemsSql);

// Revert Deleted Item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['revertItemId'])) {
    $itemId = intval($_POST['revertItemId']);

    // Fetch deleted item details
    $fetchItemSql = "SELECT * FROM deleteditem WHERE id = ?";
    $stmt = $conn->prepare($fetchItemSql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();

    if ($item) {
        // Restore to inventory (assuming table name is 'inventory')
        // Omit the id column from the INSERT statement
        $restoreItemSql = "INSERT INTO inventory (productname, qty, price, category) VALUES (?, ?, ?, ?)";
        $restoreStmt = $conn->prepare($restoreItemSql);
        $restoreStmt->bind_param("siis", $item['deletedproduct'], $item['qty'], $item['price'], $item['category']);
        $restoreStmt->execute();

        // Delete from deleteditem
        $deleteItemSql = "DELETE FROM deleteditem WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteItemSql);
        $deleteStmt->bind_param("i", $itemId);
        $deleteStmt->execute();

        // Optionally add success message here
        echo "<script>alert('Item reverted successfully!'); window.location.href = window.location.href;</script>";
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
                <h2 class="historyLabel">Unavailable Products</h2>
            </div>
            <div class="tableWrap">
                <table class="historyTable">
                    <tr>
                        <th>Deleted Product</th>
                        <th>Quantity</th>
                        <th>Price Per Piece</th>
                        <th>Category</th>
                        <th>Date Deleted</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($deletedItemsResult->num_rows > 0) {
                        $counter = 1; // Initialize a counter
                        while ($row = $deletedItemsResult->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['deletedproduct']) . "</td>
                                <td>" . htmlspecialchars($row['qty']) . "</td>
                                <td>$" . number_format($row['price'], 2) . "</td>
                                <td>" . htmlspecialchars($row['category']) . "</td>
                                <td>" . htmlspecialchars($row['datedeleted']) . "</td>
                                <td>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='revertItemId' value ='" . $row['id'] . "'>
                                        <input class='deletetableButton' type='submit' value='Revert' onclick='return confirm(\"Are you sure you want to revert this item?\");'>
                                    </form>
                                </td>
                              </tr>";
                            $counter++; // Increment counter for each row
                        }
                    } else {
                        echo "<tr><td colspan='7'>No Unavailable Product Found</td></tr>";
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