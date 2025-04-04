<?php
include 'sessionchecker.php';
include 'db_connection.php';

// Fetch added items from inventory
$addedItemsSql = "SELECT * FROM addeditem ORDER BY id DESC"; // LIFO: latest first
$addedItemsResult = $conn->query($addedItemsSql);

// Fetch deleted items from deleteditem
$deletedItemsSql = "SELECT * FROM deleteditem ORDER BY id DESC"; // LIFO: latest first
$deletedItemsResult = $conn->query($deletedItemsSql);
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
                <h2 class="historyLabel">Added Items</h2>
            </div>
            <div class="tableWrap">
                <table class="historyTable">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price Per Piece</th>
                        <th>Date Added</th>
                    </tr>
                    <?php
                    if ($addedItemsResult->num_rows > 0) {
                        while ($row = $addedItemsResult->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['productname'] . "</td>
                                <td>" . $row['qty'] . "</td>
                                <td>$" . number_format($row['price'], 2) . "</td>
                                <td>" . $row['dateadded'] . "</td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No added items found</td></tr>";
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