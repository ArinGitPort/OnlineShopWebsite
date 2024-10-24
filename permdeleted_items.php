<?php
include 'sessionchecker.php';
$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch deleted items from prmdeleteditem
$deletedItemsSql = "SELECT * FROM prmdeleteditem ORDER BY id DESC"; // LIFO: latest first
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
    <style>
        /* Style for the disabled button */
        .deletetableButton:disabled {
            background-color: #d3d3d3; /* Light grey background */
            color: #808080; /* Dark grey text */
            border: 1px solid #ccc; /* Light grey border */
            cursor: not-allowed; /* Change cursor to indicate it's not clickable */
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="maindisplayDiv ">
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
                    </tr>
                    <?php
                    if ($deletedItemsResult->num_rows > 0) {
                        while ($row = $deletedItemsResult->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['deletedproduct']) . "</td>
                                <td>" . htmlspecialchars($row['qty']) . "</td>
                                <td>$" . number_format($row['price'], 2) . "</td>
                                <td>" . htmlspecialchars($row['category']) . "</td>
                                <td>" . htmlspecialchars($row['datedeleted']) . "</td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No Unavailable Product Found</td></tr>";
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
