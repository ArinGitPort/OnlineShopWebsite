<link rel="stylesheet" href="stylingfile/sidebarstyle.css">

<div class="dashboardContainer">
    <div class="dashboardProfile">
        <div>
            <h1 class="inventoryLabel">INVENTORY</h1>
        </div>
        <div><img class="userIcon" src="imgBG/bunniwinkelanotherlogo.jpg" alt=""></div>
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