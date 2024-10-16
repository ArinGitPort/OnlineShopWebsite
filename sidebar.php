<link rel="stylesheet" href="sidebarstyle.css">

<div class="dashboardContainer">
    <div class="dashboardProfile">
        <div>
            <h1 class="inventoryLabel">INVENTORY</h1>
        </div>
        <div><img class="userIcon" src="bunniwinkleIcon.jpg" alt=""></div>
        <div class="usernamelabelDiv">
            <h3 class="usernameLabel">Bunniwinkle</h3>
        </div>
    </div>

    <div class="sidebarMenuContainer">
        <ul class="listDashboard">
            <li>
                <div class="listDiv">
                    <img src="iconlogo/home.png" class="imgIcon">
                    <a href="home.php" class="menuDashboard">HOME</a>
                </div>
            </li>
            <li>
                <div class="listDiv">
                    <img src="iconlogo/order.png" class="imgIcon">
                    <a href="productorder.php" class="menuDashboard">ORDER</a>
                </div>
            </li>
            <li>
                <div class="listDiv">
                    <img src="iconlogo/shopping-list.png" class="imgIcon">
                    <a href="inventory.php" class="menuDashboard">PRODUCTS</a>
                </div>
            </li>
            <li class="dropdown">
                <div class="listDiv dropdown-container">
                    <img src="iconlogo/history.png" class="imgIcon">
                    <a href="javascript:void(0);" class="menuDashboard" onclick="toggleDropdown()">HISTORY</a>
                    <ul class="dropdown-content" id="dropdownContent">
                        <li><a href="added_items.php" class="dropdown-item">Added Items</a></li>
                        <li><a href="deleted_items.php" class="dropdown-item">Deleted Items</a></li>
                        <li><a href="order_history.php" class="dropdown-item">Completed Order</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="listDiv">
                    <img src="iconlogo/logout.png" class="imgIcon">
                    <a href="logout.php" class="menuDashboard">LOG-OUT</a>
                </div>
            </li>
        </ul>
    </div>
</div>


<style>
    /* Dropdown Menu Styles */
    .dropdown {
        position: relative;
        text-align: center;
    }

    .dropdown-container {
        display: inline-block;
        position: relative;
        width: 100%;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        left: 44.5%;
        transform: translateX(-50%);
        background-color: #97ada3;
        width: 100%;
        border-right: solid 1px;
        z-index: 1;
        padding-left:  20px;
        margin: 0;
    }

    .dropdown-item {
        margin: 0;
        padding-top: 20px;
        color: white;
        text-decoration: none;
        display: block;
        font-size: 18px;
        font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif;
    }

    
</style>

<script>
    function toggleDropdown() {
        const dropdownContent = document.getElementById('dropdownContent');
        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none';
        } else {
            dropdownContent.style.display = 'block';
        }
    }
</script>
