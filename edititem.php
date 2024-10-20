<?php
$conn = new mysqli("localhost", "root", "", "logindb");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

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

    $update_sql = "UPDATE inventory SET productname = '$productName', qty = '$qty', price = '$price' WHERE id = $id";
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
        <label>Product Name</label><br>
        <input type="text" name="productname" value="<?php echo $row['productname']; ?>" required><br><br>
        <label>Quantity</label><br>
        <input type="number" name="qty" value="<?php echo $row['qty']; ?>" required><br><br>
        <label>Price</label><br>
        <input type="number" name="price" value="<?php echo $row['price']; ?>" required><br><br>
        <div class="editformButton">
        <input class="updateButton" type="submit" value="Update Product">
        <input class="backButton" type="button" name="goback" value="Back" onclick="location.href='Inventory.php';">
    </form>
    </div>
    </div>
    </div>
</body>

</html>
