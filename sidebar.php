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
                <div>
                    <a href="home.php" class="menuDashboard">HOME</a></div>
            </li>
            <li>
                <div><a href="productorder.php" class="menuDashboard">ORDER</a></div>
            </li>
            <li>
                <div><a href="inventory.php" class="menuDashboard">PRODUCTS</a></div>
            </li>
            <li class="dropdown">
                <div class="dropdown-container">
                    <a href="javascript:void(0);" class="menuDashboard" onclick="toggleDropdown()">HISTORY</a>
                    <ul class="dropdown-content" id="dropdownContent">
                        <li><a href="added_items.php" class="dropdown-item">Added Items</a></li>
                        <li><a href="deleted_items.php" class="dropdown-item">Deleted Items</a></li>
                        <li><a href="order_history.php" class="dropdown-item">Completed Order</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div><a href="logout.php" class="menuDashboard">LOG-OUT</a></div>
            </li>
        </ul>
    </div>
</div>

<style>
    /* Dropdown Menu Styles */
    .dropdown {
        position: relative;
        text-align: center; /* Center align text in dropdown */
    }

    .dropdown-container {
        display: inline-block; /* Center the dropdown container */
        position: relative;
        width: 100%;
    }

    .dropdown-content {
        display: none; /* Hide by default */
        position: absolute;
        left: 44.5%; /* Position from the left */
        transform: translateX(-50%); /* Center it horizontally */
        background-color: #97ada3; /* Matches sidebar background */
        width: 100%; /* Adjust width if needed */
        border-right:solid 1px;
        z-index: 1;
    }

    .dropdown-item {
        color: white; /* Matches the menu color */
        padding: 10px 15px; /* Add some padding */
        text-decoration: none;
        display: block;
        font-size: 20px; /* Font size for dropdown items */
        font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif; /* Updated font-family */
        text-align: center; /* Center the text */
        transition: all 0.3s ease; /* Add transition effect */
    }

    .dropdown-item:hover {
        background-color: #354359; /* Hover effect */
        transform: scale(1.1); /* Slightly enlarge on hover */
    }
</style>

<script>
    function toggleDropdown() {
        const dropdownContent = document.getElementById('dropdownContent');
        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none'; // Hide dropdown
        } else {
            dropdownContent.style.display = 'block'; // Show dropdown
        }
    }
</script>
