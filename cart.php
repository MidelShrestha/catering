<?php
session_start();
include('connection.php');

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    // Fetch product details from the database
    $query = "SELECT name, price FROM products WHERE id='$product_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $item_name = $product['name'];
        $price = $product['price'];

        // Check if the item is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            // Add new item to the cart
            $_SESSION['cart'][$product_id] = [
                'item_name' => $item_name,
                'price' => $price,
                'quantity' => 1
            ];
        }

        // Redirect to the cart or another page
        header('Location: show_cart.php');
        exit();
    }
}
?>
