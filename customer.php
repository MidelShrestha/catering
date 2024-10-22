<?php
session_start();
include('connection.php');

// Check if the user is logged in and is a customer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="customer.css"> 
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Customer Panel</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="customer.php">Dashboard</a></li>
                <li><a href="products.php">Available Products</a></li>
                <li><a href="update_userc.php">Account Settings</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Main Dashboard Content -->
        <div class="dashboard-content">
            <header>
                <h1>Welcome!!</h1>
            </header>

            <section class="overview">
                <h2>Customer Dashboard</h2>
                <div class="stats">
                    <div class="stat-item">
                        <h3>Pending Orders</h3>
                    </div>
                    <div class="stat-item">
                        <h3>Total Spent</h3>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
