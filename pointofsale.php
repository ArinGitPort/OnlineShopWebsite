<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/maindisplay.css">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale (POS)</title>
    <style>
        body {
            background: rgb(238,174,202);
            background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .posWrapper {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        /* Left side: Cart / Selected Items */
        .leftPanel {
            width: 30%;
            background-color: rgba(255, 255, 255, 0.8);
            border-right: 2px solid #ccc;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .cartHeader {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .customerInfo {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .customerInfo label {
            font-weight: 600;
        }

        .customerInfo input,
        .customerInfo select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .cartItems {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            overflow-y: auto;
        }

        .cartItemBox {
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            transition: transform 0.3s ease, box-shadow 0.3s;
        }

        .cartItemBox:hover {
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
        }

        .cartItemName {
            font-size: 16px;
            font-weight: 600;
        }

        .cartItemDetails {
            font-size: 14px;
            color: #666;
        }

        .cartItemActions {
            display: flex;
            gap: 10px;
        }

        .cartItemButton {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            background-color: pink;
            transition: background-color 0.3s ease, transform 0.3s;
        }

        .cartItemButton:hover {
            background-color: hotpink;
            transform: scale(1.05);
            color: #fff;
        }

        .checkoutPanel {
            margin-top: 20px;
            text-align: center;
        }

        .totalAmount {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .checkoutButton {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            background-color: pink;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s;
        }

        .checkoutButton:hover {
            background-color: hotpink;
            transform: scale(1.05);
        }

        /* Right side: Item Listing */
        .rightPanel {
            width: 70%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 20px;
        }

        h2 {
            margin: 0;
            margin-bottom: 15px;
        }

        .searchBar {
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .itemsContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            width: 100%;
            flex: 1;
            overflow-y: auto;
        }

        .itemBox {
            width: 150px;
            height: 220px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s;
            padding: 10px;
        }

        .itemBox:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .itemName {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .itemQuantity {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .itemPrice {
            font-size: 16px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="posWrapper">
        <!-- Left Side: Cart / Selected Items -->
        <div class="leftPanel">
            <div class="cartHeader">Cart / Selected Items</div>
            <!-- Customer and Payment Details -->
            <div class="customerInfo">
                <label for="customerName">Customer Name:</label>
                <input id="customerName" type="text" placeholder="Enter Customer Name..."/>
                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod">
                    <option value="cash">Cash</option>
                    <option value="credit">Credit Card</option>
                    <option value="mobile">Mobile Payment</option>
                </select>
            </div>
            <div class="cartItems">
                <!-- Example cart items with placeholders for quantity and price -->
                <div class="cartItemBox">
                    <span class="cartItemName">Selected Item 1</span>
                    <span class="cartItemDetails">Qty: 1 | Price: $10.00</span>
                    <div class="cartItemActions">
                        <button class="cartItemButton">Edit</button>
                        <button class="cartItemButton">Remove</button>
                    </div>
                </div>
                <div class="cartItemBox">
                    <span class="cartItemName">Selected Item 2</span>
                    <span class="cartItemDetails">Qty: 2 | Price: $20.00</span>
                    <div class="cartItemActions">
                        <button class="cartItemButton">Edit</button>
                        <button class="cartItemButton">Remove</button>
                    </div>
                </div>
                <div class="cartItemBox">
                    <span class="cartItemName">Selected Item 3</span>
                    <span class="cartItemDetails">Qty: 3 | Price: $30.00</span>
                    <div class="cartItemActions">
                        <button class="cartItemButton">Edit</button>
                        <button class="cartItemButton">Remove</button>
                    </div>
                </div>
            </div>
            <div class="checkoutPanel">
                <div class="totalAmount">Total: $60.00</div>
                <hr>
                <button class="checkoutButton">Proceed to Checkout</button>
            </div>
        </div>

        <!-- Right Side: Item Listing -->
        <div class="rightPanel">
            <h2>Point of Sale (POS)</h2>
            <input type="text" class="searchBar" placeholder="Search for an item...">
            <div class="itemsContainer">
                <!-- Each item now shows placeholders for name, quantity, and price -->
                <div class="itemBox">
                    <span class="itemName">Item 1</span>
                    <span class="itemQuantity">Qty: 1</span>
                    <span class="itemPrice">$10.00</span>
                </div>
                <div class="itemBox">
                    <span class="itemName">Item 2</span>
                    <span class="itemQuantity">Qty: 2</span>
                    <span class="itemPrice">$20.00</span>
                </div>
                <div class="itemBox">
                    <span class="itemName">Item 3</span>
                    <span class="itemQuantity">Qty: 3</span>
                    <span class="itemPrice">$30.00</span>
                </div>
                <div class="itemBox">
                    <span class="itemName">Item 4</span>
                    <span class="itemQuantity">Qty: 4</span>
                    <span class="itemPrice">$40.00</span>
                </div>
                <div class="itemBox">
                    <span class="itemName">Item 5</span>
                    <span class="itemQuantity">Qty: 5</span>
                    <span class="itemPrice">$50.00</span>
                </div>
                <div class="itemBox">
                    <span class="itemName">Item 6</span>
                    <span class="itemQuantity">Qty: 6</span>
                    <span class="itemPrice">$60.00</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
