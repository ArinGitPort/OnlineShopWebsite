<?php
session_start();
$conn = new mysqli("localhost", "root", "1234", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from inventory, including the category
$inventorySql = "SELECT productname, price, qty, category FROM inventory"; // Include category
$inventoryResult = $conn->query($inventorySql);

// Handle form submission
if (isset($_POST['addOrder'])) {
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
        $newCategory = $product['category']; // Get category from fetched product

        if ($newQty <= $currentQty) { // Check if there is enough stock
            // Insert into the order table with customer name and fetched category
            $sql = "INSERT INTO productorder (productname, qty, price, category, customername) 
                    VALUES ('$selectedProduct', $newQty, $newPrice, '$newCategory', '$customerName')";

            if ($conn->query($sql) === TRUE) {
                // Reduce quantity in the inventory table
                $updatedQty = $currentQty - $newQty;
                $updateSql = "UPDATE inventory SET qty = ? WHERE productname = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("is", $updatedQty, $selectedProduct);
                $updateStmt->execute();

                // Redirect to the main page after adding the order
                header("Location: productorder.php");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Not enough stock available for this product.')</script>";
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
    <title>Add New Order</title>
    <style>
        .button-container {
            display: flex;
            gap: 10px; /* Space between buttons */
            margin-top: 20px;
        }

        .addnewOrder,
        .orderbackButton {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Add Order Form -->
    <form method="POST" action="">
        <div class="addinputField">
            <h2>Add New Order</h2>

            <!-- Product Dropdown -->
            <label for="productDropdown">Product Name</label>
            <select name="productDropdown" id="productDropdown" class="orderprodnameField" required>
                <option value="">Select Product</option>
                <?php
                // Fetch and display products
                if ($inventoryResult->num_rows > 0) {
                    while ($row = $inventoryResult->fetch_assoc()) {
                        echo "<option value='" . $row['productname'] . "'>" . $row['productname'] . " - $" . $row['price'] . " (Category: " . $row['category'] . ")</option>";
                    }
                } else {
                    echo "<option value=''>No products available</option>";
                }
                ?>
            </select>

            <label for="newQty">Quantity</label>
            <input class="orderprodqtyField" type="number" id="newQty" name="newQty" placeholder="Quantity" required min="0">

            <label for="customerName">Customer Name</label>
            <input class="customernameField" type="text" id="customerName" name="customerName" placeholder="Customer Name" required>

            <!-- Button Container -->
            <div class="button-container">
                <button type="submit" name="addOrder" class="addnewOrder">Add Order</button>
                <button type="button" class="orderbackButton" onclick="window.location.href='productorder.php';">Back</button>
            </div>
        </div>
    </form>
</body>
</html>
