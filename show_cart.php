<?php
session_start();
include('connection.php');

// Initialize total price
$total_price = 0;

// Check if the cart exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Process the selected dishes if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_dishes'])) {
    
    foreach ($_POST['selected_dishes'] as $dish_id) {
        $result = mysqli_query($conn, "SELECT * FROM customizations WHERE id = '$dish_id'");
        $dish = mysqli_fetch_assoc($result);    
        if ($dish) {
            
            array_push($_SESSION['cart'], [
                'id' => $dish['id'],
                'item_name' => $dish['name'],
                'price' => $dish['price'],
                'quantity' => 1 // Initial quantity for internal use
            ]);
        }

    }
}else if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='products.php'>Back to Products</a></p>";
    exit();
}

// Handle the total number of people input
$total_people = 1; // Default value
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['total_people'])) {
    $total_people = max(1, (int)$_POST['total_people']); // Ensure at least 1
}

// Calculate total price based on total number of people
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $total_people;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Your Selected Dishes</h2>
        <form method="POST" action="show_cart.php"> <!-- Form for updating total people -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Dish Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['cart'] as $item) {
                        if (isset($item['item_name']) && isset($item['price'])) {
                            echo "<tr>
                                <td>{$item['item_name']}</td>
                                <td>Rs. {$item['price']}</td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

            <h4>Total Price: Rs. <?php echo number_format($total_price, 2); ?></h4>

            <h4>Total Number of People:</h4>
            <input type="number" name="total_people" value="<?php echo $total_people; ?>" min="1" style="width: 100px;" class="form-control mb-3">

            <button type="submit" class="btn btn-primary">Update Total Price</button>
        </form>

        <h3>Proceed to Checkout</h3>
        <form action="checkout.php" method="POST">
            <!-- Add booking date and time fields -->
            <input type="hidden" name="total_people" value="<?php echo $total_people; ?>"> <!-- Include total_people -->

            <div class="mb-3">
                <label for="booking_date" class="form-label">Booking Date</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date" required>
            </div>
            <div class="mb-3">
                <label for="booking_time" class="form-label">Booking Time</label>
                <input type="time" class="form-control" id="booking_time" name="booking_time" required>
            </div>
            <div class="mb-3">
                <label for="event_type" class="form-label">Event Type</label>
                <select class="form-select" id="event_type" name="event_type" required>
                    <option value="" disabled selected>Select Event Type</option>
                    <option value="Wedding">Wedding</option>
                    <option value="Birthday">Birthday</option>
                    <option value="Corporate">Corporate Event</option>
                    <option value="Anniversary">Anniversary</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Proceed to Checkout</button>
        </form>

        <a href="products.php" class="btn btn-secondary mt-3">Back to Products</a>
    </div>
</body>
</html>
