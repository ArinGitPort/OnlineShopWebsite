<?php
include 'sessionchecker.php';

include 'db_connection.php';

// Add new product to the inventory table
if (isset($_POST['addProduct'])) {
    $newProduct = $conn->real_escape_string($_POST['newProduct']);
    $newQty = (int) $_POST['newQty'];
    $newPrice = (float) $_POST['newPrice'];
    $newCategory = $conn->real_escape_string($_POST['newCategory']); // Category field

    // Check if product name already exists
    $checkDuplicateSql = "SELECT * FROM inventory WHERE productname='$newProduct'";
    $duplicateResult = $conn->query($checkDuplicateSql);

    if ($duplicateResult->num_rows > 0) {
        // Product name exists, show an error message
        echo "<script>alert('Error: Product name already exists.');</script>";
    } else {
        // Insert into the inventory table if no duplicate
        $sql = "INSERT INTO inventory (productname, qty, price, category) 
                VALUES ('$newProduct', $newQty, $newPrice, '$newCategory')";

        if ($conn->query($sql) === TRUE) {
            // Get the ID of the newly added product
            $newProductId = $conn->insert_id;

            // Insert into the addeditem table to record the addition
            $dateAdded = date("Y-m-d H:i:s"); // Get current date and time
            $addHistorySql = "INSERT INTO addeditem (productname, qty, price, dateadded) 
                              VALUES ('$newProduct', $newQty, $newPrice, '$dateAdded')";

            if ($conn->query($addHistorySql) === TRUE) {
                // Redirect to the main page after adding the product and recording it in addeditem
                header("Location: inventory.php");
                exit;
            } else {
                echo "Error: Could not record added product: " . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <title>Add New Product</title>
    <style>
        .button-container {
            display: flex;
            gap: 10px;
            /* Space between buttons */
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Add Product Form -->
    <form method="POST" action="">
        <div class="addinputField">
            <h2>Add New Product</h2>
            <label for="newProduct">Product Name</label>
            <input class="prodcategoryField" type="text" id="newProduct" name="newProduct" placeholder="Product Name"
                required>

            <label for="newQty">Quantity</label>
            <input class="prodcategoryField" type="number" id="newQty" name="newQty" placeholder="Quantity" required
                min="1">

            <label for="newPrice">Price</label>
            <input class="prodcategoryField" type="number" step="0.01" id="newPrice" name="newPrice" placeholder="Price"
                required min="0.01">

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

            <div class="button-container">
                <button type="submit" class="sortAlphaButton" name="addProduct" class="addnewProduct">Add
                    Product</button>
                <button type="button" class="sortAlphaButton"
                    onclick="window.location.href='inventory.php';">Back</button>
            </div>
        </div>
    </form>
</body>

</html>