<?php
include 'sessionchecker.php';

$conn = new mysqli("localhost", "root", "", "logindb");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Query to get the total number of items sold and total sales by category
$sql = "SELECT category, COUNT(*) as total_items_sold, SUM(price * qty) as total_sales FROM orderhistory GROUP BY category";
$result = $conn->query($sql);

$categories = [];
$totalItemsSold = [];
$totalSales = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
        $totalItemsSold[] = $row['total_items_sold']; // Total items sold
        $totalSales[] = $row['total_sales']; // Total sales
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/graph.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Ordered Products by Category</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head >

<body>
    <?php include 'sidebar.php' ?>

    <div class="graphContainer">
        <div class="h2Div">
            <h2>Most Ordered Products by Category</h2>
        </div>
        <div style="width: 50%; margin: auto;">
            <canvas id="orderChart"></canvas>
        </div>
    </div>

    <script>
        // Fetch PHP data from the server
        var categories = <?php echo json_encode($categories); ?>;
        var totalItemsSold = <?php echo json_encode($totalItemsSold); ?>;
        var totalSales = <?php echo json_encode($totalSales); ?>;

        // Initialize the chart
        var ctx = document.getElementById('orderChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Total Orders',
                    data: totalItemsSold,
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1,
                    yAxisID: 'y-axis-1',
                }, {
                    label: 'Total Sales ($)',
                    data: totalSales,
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1,
                    yAxisID: 'y-axis-2',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        id: 'y-axis-1',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Total Items Sold'
                        }
                    }, {
                        id: 'y-axis-2',
                        type: 'linear',
                        position: 'right',
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Total Sales ($)'
                        }
                    }]
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Graph of Completed Orders by Category'
                    }
                }
            }
        });
    </script>

</body>

</html>