<?php
session_start();
$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID of the order to edit
$orderId = $_GET['edit_id'];

// Fetch the current order details
$orderSql = "SELECT productname, qty, customername FROM productorder WHERE id = ?";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();

// Fetch products from inventory, including the category
$inventorySql = "SELECT productname, price, qty, category FROM inventory"; // Include category
$inventoryResult = $conn->query($inventorySql);

// Handle form submission
if (isset($_POST['editOrder'])) {
    $selectedProduct = $conn->real_escape_string($_POST['productDropdown']);
    $newQty = (int)$_POST['newQty'];
    $customerName = $conn->real_escape_string($_POST['customerName']);

    // Fetch price, current quantity, and category of the selected product
    $priceSql = "SELECT price, qty, category FROM inventory WHERE productname = ?";
    $stmt = $conn->prepare($priceSql);
    $stmt->bind_param("s", $selectedProduct);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $newPrice = (float)$product['price'];
        $currentQty = (int)$product['qty'];

        // Get the current quantity ordered
        $currentOrderQty = (int)$order['qty'];

        // Calculate the total quantity needed after the change
        $totalQtyNeeded = $newQty - $currentOrderQty;

        // Check if enough stock is available if changing products or quantities
        if ($selectedProduct !== $order['productname']) {
            // Check if there is enough stock for the new product
            if ($newQty > $currentQty) {
                echo "Not enough stock available for this product.";
                exit;
            }
        } else {
            // If the product is the same, ensure there is enough stock for the new quantity
            if ($newQty > currentQty + currentOrderQty) {
                echo "Not enough stock available for this product.";
                exit;
            }
        }

        // Update the order table with customer name and fetched category
        $sql = "UPDATE productorder SET productname = '$selectedProduct', qty = $newQty, price = $newPrice, customername = '$customerName' WHERE id = $orderId";

        if ($conn->query($sql) === TRUE) {
            // Update inventory regardless of whether the product has changed
            // If the product is changed, we add back the old order qty and subtract the new order qty
            if ($selectedProduct !== $order['productname']) {
                // Reduce the quantity in the inventory table for the selected product
                $updatedQty = $currentQty - $newQty; // New product qty
                $updateSql = "UPDATE inventory SET qty = ? WHERE productname = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("is", $updatedQty, $selectedProduct);
                $updateStmt->execute();

                // Restore quantity of the old product back to inventory
                $oldProduct = $order['productname'];
                $oldProductQty = (int)$order['qty'];

                $restoreSql = "UPDATE inventory SET qty = qty + ? WHERE productname = ?";
                $restoreStmt = $conn->prepare($restoreSql);
                $restoreStmt->bind_param("is", $oldProductQty, $oldProduct);
                $restoreStmt->execute();
            } else {
                // If the product hasn't changed, just update the inventory quantity based on the new quantity
                $adjustedQty = $currentQty + $currentOrderQty - $newQty;
                $adjustQtySql = "UPDATE inventory SET qty = ? WHERE productname = ?";
                $adjustQtyStmt = $conn->prepare($adjustQtySql);
                $adjustQtyStmt->bind_param("is", $adjustedQty, $selectedProduct);
                $adjustQtyStmt->execute();
            }

            // Redirect to the main page after updating the order
            header("Location: productorder.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Product not found.";
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
    <title>Edit Order</title>
    <style>
        .button-container {
            display: flex;
            gap: 10px; /* Space between buttons */
            margin-top: 20px;
        }

        .editOrder,
        .orderbackButton {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Edit Order Form -->
    <form method="POST" action="">
        <div class="addinputField">
            <h2>Edit Order</h2>

            <!-- Product Dropdown -->
            <label for="productDropdown">Product Name</label>
            <select name="productDropdown" id="productDropdown" class="orderprodnameField" required>
                <option value="">Select Product</option>
                <?php
                // Fetch and display products
                if ($inventoryResult->num_rows > 0) {
                    while ($row = $inventoryResult->fetch_assoc()) {
                        echo "<option value='" . $row['productname'] . "'" . ($row['productname'] == $order['productname'] ? ' selected' : '') . ">" . $row['productname'] . " - $" . $row['price'] . " (Category: " . $row['category'] . ")</option>";
                    }
                } else {
                    echo "<option value=''>No products available</option>";
                }
                ?>
            </select>

            <label for="newQty">Quantity</label>
            <input class="orderprodqtyField" type="number" id="newQty" name="newQty" placeholder="Quantity" required min="0" value="<?php echo htmlspecialchars($order['qty']); ?>">

            <label for="customerName">Customer Name</label>
            <input class="customernameField" type="text" id="customerName" name="customerName" placeholder="Customer Name" required value="<?php echo htmlspecialchars($order['customername']); ?>">

            <!-- Button Container -->
            <div class="button-container">
                <button type="submit" name="editOrder" class="orderbackButton">Update Order</button>
                <button type="button" class="orderbackButton" onclick="window.location.href='productorder.php';">Back</button>
            </div>
        </div>
    </form>
</body>
</html>
