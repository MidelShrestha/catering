<?php
include('connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $product_id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $image = $row['image'];
        $components = explode(",", $row['components']);
        
        $sql2 = "SELECT * FROM customizations";
        $result2 = mysqli_query($conn, $sql2);
        
    
    } else {
        die(mysqli_error($conn));
    }
    
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $checkedComponents = $_POST['components'] ?? []; // Use empty array if none selected

    // Construct the components string
    $checkedComponentsString = implode(',', $checkedComponents);
    
    // Handle file upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "images/".basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "UPDATE products SET name = '$name',components = '$checkedComponentsString', description = '$description', price = '$price', image = '$image' WHERE id = $id";
    } else {
        $sql = "UPDATE products SET name = '$name',components = '$checkedComponentsString', description = '$description', price = '$price' WHERE id = $id";
    }

    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: update_product.php?id='.$id);
    } else {
        die(mysqli_error($conn));
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Product</title>
</head>
<body>
    <div class="container my-5">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" required><?php echo $description; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $price; ?>" required>
            </div>
            <input type='hidden' name='id' value="<?=$product_id?>">

            


            <table class="table">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if($components) {?>
            <?php $i=1; while ($customizations = mysqli_fetch_assoc($result2)) { ?>
                <tr>
                    <td><?=$customizations['id']?></td>
                    <td><?=$customizations['name']?></td>
                    <td><?=$customizations['price']?></td>
                    <td><input type='checkbox' name='components[]' value="<?=$customizations['id']?>" id='<?=$customizations['id']?>' <?php if(in_array($customizations['id'], $components)){echo 'checked';}?>  class=''></td>             
                </tr>
            <?php } ?>
            <?php } else {?>
                <tr><td>No Components</td></tr>
            <?php }?>
            </tbody>
        
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" name="image" accept="image/*">
            </div>
            
            <button type="submit" class="btn btn-primary" name="submit">Update Product</button>
            <a href="customize_dish.php?id='.$id.'" class="btn btn-danger">Customize</a>
            <a href="manage_products.php" class="btn btn-secondary mt-1">Back</a>

        </form>
    </div>
</body>
</html>
