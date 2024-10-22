<?php
session_start();
include('connection.php');

// Process the submitted dish
if (isset($_POST['dish_name']) && isset($_POST['dish_price'])) {
    $dish_name = mysqli_real_escape_string($conn, $_POST['dish_name']);
    $dish_price = mysqli_real_escape_string($conn, $_POST['dish_price']);

    // Insert the new dish (customization) into the customizations table
    $sql = "INSERT INTO customizations (name, price) VALUES ('$dish_name', '$dish_price')";

    if (mysqli_query($conn, $sql)) {
        // Redirect after successful addition
        header('Location: customize_dish.php');
        exit(); // Ensure script stops after redirect
    } else {
        // Show error without using header
        echo "Error adding dish: " . mysqli_error($conn);
    }
}

// Process price update
if (isset($_POST['update_id']) && isset($_POST['update_price'])) {
    $update_id = mysqli_real_escape_string($conn, $_POST['update_id']);
    $update_price = mysqli_real_escape_string($conn, $_POST['update_price']);

    // Update the dish price in the customizations table
    $update_sql = "UPDATE customizations SET price='$update_price' WHERE id='$update_id'";
    
    if (mysqli_query($conn, $update_sql)) {
        // Redirect after successful update
        header('Location: customize_dish.php');
        exit(); // Ensure script stops after redirect
    } else {
        echo "Error updating price: " . mysqli_error($conn);
    }
}

// Process deletion of a dish
if (isset($_POST['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    // Delete the dish from the customizations table
    $delete_sql = "DELETE FROM customizations WHERE id='$delete_id'";
    
    if (mysqli_query($conn, $delete_sql)) {
        // Redirect after successful deletion
        header('Location: customize_dish.php');
        exit(); // Ensure script stops after redirect
    } else {
        echo "Error deleting dish: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customizations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Available Customizations</h2>
        
        <!-- Display available dishes -->
        <?php
        $result = mysqli_query($conn, "SELECT * FROM customizations");
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table'><thead><tr><th>Dish Name</th><th>Price</th><th>Actions</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>
                            <form method='POST' action='customize_dish.php' class='d-flex'>
                                <input type='hidden' name='update_id' value='{$row['id']}'>
                                <input type='number' class='form-control' name='update_price' value='{$row['price']}' required>
                                <button type='submit' class='btn btn-primary'>Update</button>
                            </form>
                        </td>
                        <td>
                            <form method='POST' action='customize_dish.php'>
                                <input type='hidden' name='delete_id' value='{$row['id']}'>
                                <button type='submit' class='btn btn-danger'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No dishes available.</p>";
        }
        ?>

        <!-- Form to add new dish -->
        <h3>Add New Dish</h3>
        <form method="POST" action="customize_dish.php">
            <div class="mb-3">
                <label for="dish_name" class="form-label">Dish Name</label>
                <input type="text" class="form-control" id="dish_name" name="dish_name" required>
            </div>
            <div class="mb-3">
                <label for="dish_price" class="form-label">Price</label>
                <input type="number" class="form-control" id="dish_price" name="dish_price" required>
            </div>
            <button type="submit" class="btn btn-success">Add Dish</button>
            <a href="manage_products.php" class="btn btn-secondary mt-1">Back</a>
        </form>
    </div>
</body>
</html>
