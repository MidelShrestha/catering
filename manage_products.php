<?php
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <a href="add_product.php" class="btn btn-primary my-5">Add Product</a> 
        <a href="admin.php" class="btn btn-secondary mt-1">Back</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM products";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $name = $row['name'];
                        $description = $row['description'];
                        $price = $row['price'];

                        echo '<tr>
                            <th scope="row">'.htmlspecialchars($id).'</th>
                            <td>'.htmlspecialchars($name).'</td>
                            <td>'.htmlspecialchars($description).'</td>
                            <td>$'.htmlspecialchars($price).'</td>
                            <td>
                                <a href="update_product.php?id='.$id.'" class="btn btn-primary">Edit</a>
                                <a href="delete_product.php?id='.$id.'" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
                            </td>
                        </tr>';
                    }
                } else {
                    echo "Error fetching products: " . mysqli_error($conn);
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
