<?php include('partials/menu.php') ?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="main-content">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Dashboard</h1>
        </div>

        <!-- Total Revenue Chart -->
        <div class="row">
            <div class="col-lg-6">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Top 5 Most Bought Products Chart -->
        <div class="row">
            <div class="col-lg-6">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>

        <!-- Order Status Breakdown Chart -->
        <div class="row">
            <div class="col-lg-6">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- PHP to Fetch Data for Charts -->
<?php
// Total Revenue by Latest 5 Dates
$sql_revenue_dates = "
    SELECT DATE(oder_date) AS revenue_date, SUM(total) AS total_revenue
    FROM tbl_orders
    WHERE status='Delivered'
    GROUP BY DATE(oder_date)
    ORDER BY revenue_date DESC
    LIMIT 5
";
$res_revenue_dates = mysqli_query($conn, $sql_revenue_dates);

$revenue_dates = [];
$revenues = [];
while ($row = mysqli_fetch_assoc($res_revenue_dates)) {
    $revenue_dates[] = $row['revenue_date'];
    $revenues[] = $row['total_revenue'];
}



// Top 5 Most Bought Products
$sql_top_products = "
    SELECT food, COUNT(food) AS order_count
    FROM tbl_orders
    WHERE status='Delivered'
    GROUP BY food
    ORDER BY order_count DESC
    LIMIT 5
";
$res_top_products = mysqli_query($conn, $sql_top_products);
$top_products = [];
$order_counts = [];
while ($row = mysqli_fetch_assoc($res_top_products)) {
    $top_products[] = $row['food'];
    $order_counts[] = $row['order_count'];
}

// Order Status Breakdown
$sql_status_breakdown = "
    SELECT status, COUNT(status) AS count
    FROM tbl_orders
    GROUP BY status
";
$res_status_breakdown = mysqli_query($conn, $sql_status_breakdown);
$order_status_labels = [];
$order_status_counts = [];
while ($row = mysqli_fetch_assoc($res_status_breakdown)) {
    $order_status_labels[] = $row['status'];
    $order_status_counts[] = $row['count'];
}
?>

<!-- JavaScript to Render Charts -->
<script>
    // Total Revenue Chart
    const revenueChartCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueChartCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($revenue_dates); ?>, // Latest 5 dates
        datasets: [{
            label: 'Revenue (PHP)',
            data: <?php echo json_encode($revenues); ?>, // Revenue for each date
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

    // Top 5 Most Bought Products Chart
    const topProductsChartCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(topProductsChartCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($top_products); ?>,
            datasets: [{
                label: 'Order Count',
                data: <?php echo json_encode($order_counts); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Order Status Breakdown Chart
    const orderStatusChartCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusChartCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($order_status_labels); ?>,
            datasets: [{
                label: 'Order Status',
                data: <?php echo json_encode($order_status_counts); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

<?php include('partials/footer.php') ?>
