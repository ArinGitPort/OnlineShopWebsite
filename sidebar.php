<link rel="stylesheet" href="stylingfile/sidebarstyle.css">

<div class="pageWrapper">
  <!-- Sidebar -->
 <!-- sidebar.php -->
<aside class="sidebarContainer">
  <div class="dashboardProfile">
    <img class="userIcon" src="imgBG/bunniwinkelanotherlogo.jpg" alt="User Icon">
  </div>

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
    <li>
      <div class="listDiv">
        <img src="iconlogo/trend.png" class="imgIcon">
        <a href="graph.php" class="menuDashboard">GRAPH</a>
      </div>
    </li>
    <li class="dropdown">
      <!-- Clickable dropdown container -->
      <div class="listDiv dropdown-container" onclick="toggleDropdown()">
        <img src="iconlogo/history.png" class="imgIcon">
        <a href="javascript:void(0);" class="menuDashboard">HISTORY</a>
      </div>
      <!-- Hidden by default; toggled in JS -->
      <ul class="dropdown-content" id="dropdownContent">
        <li><a href="added_items.php" class="dropdown-item">Added Products</a></li>
        <li><a href="deleted_items.php" class="dropdown-item">Unavailable Products</a></li>
        <li><a href="permdeleted_items.php" class="dropdown-item">Deleted Products</a></li>
        <li><a href="order_history.php" class="dropdown-item">Completed Order</a></li>
      </ul>
    </li>
    <li>
      <div class="listDiv">
        <img src="iconlogo/logout.png" class="imgIcon">
        <a href="logout.php" class="menuDashboard">LOG-OUT</a>
      </div>
    </li>
  </ul>
</aside>

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
