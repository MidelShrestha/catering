<?php
session_start();
include('connection.php');

// Retrieve form data
$total_people = isset($_POST['total_people']) ? (int)$_POST['total_people'] : 1;
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$event_type = $_POST['event_type'];
$total_price = 0; // Initialize

// Calculate total price based on cart and total people
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $total_people;
    }
}

// Insert the order for each item in the cart
foreach ($_SESSION['cart'] as $item_id => $item) {
    $item_name = $item['item_name'];
    $item_price = $item['price'];

    // Insert order into database
    $sql = "INSERT INTO orders (product_id, item_name, quantity, total_price, booking_date, booking_time, status, event_type) 
            VALUES ('$item_id', '$item_name', '$total_people', '$total_price', '$booking_date', '$booking_time', 'Pending', '$event_type')";

    if (mysqli_query($conn, $sql)) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Clear the cart after order is placed
unset($_SESSION['cart']);
?>
