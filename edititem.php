<?php
$conn = new mysqli("localhost", "root", "", "logindb");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch product details
$id = $_GET['edit_id'];
$sql = "SELECT * FROM inventory WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No Records Found!";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productname'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $category = $_POST['category']; // Get the selected category from the form

    $update_sql = "UPDATE inventory SET productname = '$productName', qty = '$qty', price = '$price', category = '$category' WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Record updated successfully!";
        header("Location: Inventory.php");
        exit;
    } else {
        echo "Error updating records: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/edititem.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>

<body>
    <div class="editprodContainer">
        <h2>Edit Product</h2>
        <div class="editForm">
            <form method="POST" action="">
                <div class="editForm2">
                    <label>Product Name</label><br>
                    <input type="text" name="productname" value="<?php echo $row['productname']; ?>" required><br><br>
                    <label>Quantity</label><br>
                    <input type="number" name="qty" value="<?php echo $row['qty']; ?>" required><br><br>
                    <label>Price</label><br>
                    <input type="number" name="price" value="<?php echo $row['price']; ?>" required><br><br>
                    <label>Category</label><br>
                    <select name="category" class="prodcategoryField" required>
                        <option value="">Select a category</option>
                        <option value="General Goods" <?php echo ($row['category'] === 'General Goods') ? 'selected' : ''; ?>>General Goods</option>
                        <option value="Bunni Charms" <?php echo ($row['category'] === 'Bunni Charms') ? 'selected' : ''; ?>>Bunni Charms</option>
                        <option value="Phone Strap / Bag Charms" <?php echo ($row['category'] === 'Phone Strap / Bag Charms') ? 'selected' : ''; ?>>Phone Strap / Bag Charms</option>
                        <option value="Bunni Dolls" <?php echo ($row['category'] === 'Bunni Dolls') ? 'selected' : ''; ?>>Bunni Dolls</option>
                        <option value="Clay Earrings" <?php echo ($row['category'] === 'Clay Earrings') ? 'selected' : ''; ?>>Clay Earrings</option>
                        <option value="Clay Bracelets" <?php echo ($row['category'] === 'Clay Bracelets') ? 'selected' : ''; ?>>Clay Bracelets</option>
                        <option value="Clay Necklace" <?php echo ($row['category'] === 'Clay Necklace') ? 'selected' : ''; ?>>Clay Necklace</option>
                        <option value="Clay Pins" <?php echo ($row['category'] === 'Clay Pins') ? 'selected' : ''; ?>>Clay Pins</option>
                        <option value="Deco Stickers" <?php echo ($row['category'] === 'Deco Stickers') ? 'selected' : ''; ?>>Deco Stickers</option>
                        <option value="Notepads" <?php echo ($row['category'] === 'Notepads') ? 'selected' : ''; ?>>Notepads</option>
                        <option value="Sticker Set" <?php echo ($row['category'] === 'Sticker Set') ? 'selected' : ''; ?>>Sticker Set</option>
                        <option value="Sticker Pack" <?php echo ($row['category'] === 'Sticker Pack') ? 'selected' : ''; ?>>Sticker Pack</option>
                        <option value="Acrylic Keychain" <?php echo ($row['category'] === 'Acrylic Keychain') ? 'selected' : ''; ?>>Acrylic Keychain</option>
                        <option value="Washi Tapes" <?php echo ($row['category'] === 'Washi Tapes') ? 'selected' : ''; ?>>Washi Tapes</option>
                        <option value="Clear Stamps" <?php echo ($row['category'] === 'Clear Stamps') ? 'selected' : ''; ?>>Clear Stamps</option>
                        <option value="Boxes and Bundles" <?php echo ($row['category'] === 'Boxes and Bundles') ? 'selected' : ''; ?>>Boxes and Bundles</option>
                    </select><br><br>
                    <div class="editformButton">
                        <input class="updateButton" type="submit" value="Update Product">
                        <input class="backButton" type="button" name="goback" value="Back" onclick="location.href='Inventory.php';">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
