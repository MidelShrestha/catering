<?php
include('connection.php');

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Products Available</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                        <!-- Show button that redirects to show_dish.php -->
                        <a href="show_dish.php?product_id=<?php echo $row['id']; ?>" class="btn btn-primary">Show</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <a href="customer.php" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>
