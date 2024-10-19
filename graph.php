<?php
$conn = new mysqli("localhost", "root", "", "logindb");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Query to get the total number of orders by category
$sql = "SELECT category, COUNT(*) as total FROM orderhistory GROUP BY category";
$result = $conn->query($sql);

$categories = [];
$totals = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
        $totals[] = $row['total'];
    }
} else {
    echo "No data found!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/graph.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Ordered by Category</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include 'sidebar.php' ?>

    <div class="graphContainer">
        <div class="h2Div">
            <h2>Most Ordered by Category</h2>
        </div>
        <div style="width: 50%; margin: auto;">
            <canvas id="orderChart"></canvas>
        </div>
    </div>
    
    <script>
        // Fetch PHP data from the server
        var categories = <?php echo json_encode($categories); ?>;
        var totals = <?php echo json_encode($totals); ?>;

        // Initialize the chart
        var ctx = document.getElementById('orderChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Completed Orders by Category',
                    data: totals,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Completed Orders by Category'
                    }
                }
            }
        });
    </script>

</body>

</html>