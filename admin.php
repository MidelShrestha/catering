<?php
session_start();
include('connection.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Fetch statistics from the database
$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$total_events = $conn->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
$pending_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'")->fetch_assoc()['count'];

// Fetch events from the database
$events = mysqli_query($conn, "SELECT * FROM events");

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->

</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Admin</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="order.php">Manage Orders</a></li>
                <li><a href="manage_products.php">Manage Menus</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="dashboard-content">
            <!-- Header -->
            <header>
                <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            </header>

            <!-- Overview Section -->
            <section class="overview">
                <h2>Admin Dashboard</h2>
                <div class="stats">
                    <div class="stat-item">
                        <h3>Total Orders</h3>
                        <p><?php echo $total_orders; ?></p>
                    </div>
                    <div class="stat-item">
                        <h3>Pending Orders</h3>
                        <p><?php echo $pending_orders; ?></p>
                    </div>
                </div>

                <!-- Chart Container -->
                <div class="chart-container">
                    <canvas id="ordersChart"></canvas> <!-- Canvas for Chart.js -->
                </div>
            </section>
        </div>
    </div>

    <script>
        // Prepare data for the chart
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ctx, {
            type: 'bar', // Type of chart
            data: {
                labels: ['Total Orders', 'Pending Orders'], // Labels for the chart
                datasets: [{
                    label: 'Orders',
                    data: [<?php echo $total_orders; ?>, <?php echo $pending_orders; ?>], // Data from PHP
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)', // Color for Total Orders
                        'rgba(255, 99, 132, 0.2)'  // Color for Pending Orders
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)', // Border color for Total Orders
                        'rgba(255, 99, 132, 1)'  // Border color for Pending Orders
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Start y-axis at 0
                    }
                }
            }
        });
    </script>
</body>
</html>
