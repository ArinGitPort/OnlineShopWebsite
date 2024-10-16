<?php
session_start();
$conn = new mysqli("localhost", "root", "", "logindb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new order to the order table only
if (isset($_POST['addOrder'])) {
    $newProduct = $conn->real_escape_string($_POST['newProduct']);
    $newQty = (int) $_POST['newQty'];
    $newPrice = (float) $_POST['newPrice'];
    $newCategory = $conn->real_escape_string($_POST['newCategory']);
    $customerName = $conn->real_escape_string($_POST['customerName']); // New Customer Name Field

    // Insert into the order table with customer name
    $sql = "INSERT INTO productorder (productname, qty, price, category, customername) 
            VALUES ('$newProduct', $newQty, $newPrice, '$newCategory', '$customerName')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the main page after adding the order
        header("Location: productorder.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
</head>

<body>
    <!-- Add Order Form -->
    <form method="POST" action="">
        <div class="addinputField">
            <h2>Add New Order</h2>
            <label for="newProduct">Product Name</label>
            <input class="orderprodnameField" type="text" id="newProduct" name="newProduct" placeholder="Product Name"
                required>

            <label for="newQty">Quantity</label>
            <input class="orderprodqtyField" type="number" id="newQty" name="newQty" placeholder="Quantity" required>

            <label for="newPrice">Price</label>
            <input class="orderprodpriceField" type="number" step="0.01" id="newPrice" name="newPrice"
                placeholder="Price" required>

            <!-- Category Dropdown -->
            <label for="newCategory">Category</label>
            <select name="newCategory" id="newCategory" class="prodcategoryField" required>
                <option value="General Goods">General Goods</option>
                <option value="Bunni Charms">Bunni Charms</option>
                <option value="Phone Strap / Bag Charms">Phone Strap / Bag Charms</option>
                <option value="Bunni Dolls">Bunni Dolls</option>
                <option value="Clay Earrings">Clay Earrings</option>
                <option value="Clay Bracelets">Clay Bracelets</option>
                <option value="Clay Necklace">Clay Necklace</option>
                <option value="Clay Pins">Clay Pins</option>
                <option value="Deco Stickers">Deco Stickers</option>
                <option value="Notepads">Notepads</option>
                <option value="Sticker Set">Sticker Set</option>
                <option value="Sticker Pack">Sticker Pack</option>
                <option value="Acrylic Keychain">Acrylic Keychain</option>
                <option value="Washi Tapes">Washi Tapes</option>
                <option value="Clear Stamps">Clear Stamps</option>
                <option value="Boxes and Bundles">Boxes and Bundles</option>
            </select>


            <label for="customerName">Customer Name</label>
            <input class="customernameField" type="text" id="customerName" name="customerName"
                placeholder="Customer Name" required>

            <button type="submit" name="addOrder" class="addnewOrder">Add Order</button>
        </div>
    </form>

    <!-- Back Button -->
    <form method="GET" action="productorder.php">
        <button type="submit" class="backButton">Back to Product Orders</button>
    </form>
</body>

</html>