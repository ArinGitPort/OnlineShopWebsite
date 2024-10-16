<?php
session_start();
$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>

</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="maindisplayDiv">
        <div class="insideTabelDisplayDiv">
            <div class="historylabelDiv">
                <h2 class="historyLabel">Deleted Items</h2>
            </div>
            <div class="tableWrap">
                <table class="historyTable">
                    <tr>
                        <th>ID</th>
                        <th>Deleted Product</th>
                        <th>Date Deleted</th>

                    </tr>
                    <?php
                    if ($deletedItemsResult->num_rows > 0) {
                        while ($row = $deletedItemsResult->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['deletedproduct'] . "</td>
                                <td>" . $row['datedeleted'] . "</td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No deleted items found</td></tr>";
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