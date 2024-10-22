<?php
session_start();
include('connection.php');

// Handle the order status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
 
    // Update the order status in the database
    $update_sql = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";
    mysqli_query($conn, $update_sql);
}
    print_r($_SESSION["username"]);
// Fetch all orders from the database
$sql = "SELECT order_id, item_name, quantity, status, booking_date, booking_time, event_type FROM orders"; // Include quantity (total_people)
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Customer Orders</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Item Name</th>
                    <th>Total People</th> <!-- Display total number of people -->
                    <th>Status</th>
                    <th>Booking Date</th>
                    <th>Booking Time</th>
                    <th>Event Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['order_id']}</td>
                            <td>{$row['item_name']}</td>
                            <td>{$row['quantity']}</td> <!-- Display total people -->
                            <td>{$row['status']}</td>
                            <td>{$row['booking_date']}</td>
                            <td>{$row['booking_time']}</td>
                            <td>{$row['event_type']}</td>
                            <td>
                                <form method='POST' action='order.php'>
                                    <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                    <select name='status' class='form-select'>
                                        <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                        <option value='Confirm' " . ($row['status'] == 'Confirm' ? 'selected' : '') . ">Confirmed</option>
                                        <option value='Cancelled' " . ($row['status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                                    </select>
                                    <button type='submit' name='update_status' class='btn btn-primary btn-sm'>Update</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
