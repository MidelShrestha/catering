<?php
include('connection.php');

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
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
        
        $sql2 = "SELECT * FROM customizations where id in (";
        if($components){
            foreach($components as $component){
                $sql2 .= $component.",";
            }
            $sql2 = substr($sql2, 0, -1) . ')';
            $result2 = mysqli_query($conn, $sql2);
        }
    
    } else {
        die(mysqli_error($conn));
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Dishes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validateSelection() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length < 5) {
                alert("Please select at least 5 dishes.");
                return false; // Prevent form submission
            }
            return true; // Proceed with form submission
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h2>Select Dishes</h2>
        <form method="POST" action="show_cart.php" onsubmit="return validateSelection()">
            <div class="list-group">
                <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                    <div class="list-group-item">
                        <input type="checkbox" name="selected_dishes[]" value="<?=$row['id']?>">
                        <?php echo $row['name']; ?> - Rs. <?php echo $row['price']; ?>
                    </div>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Proceed</button>
        </form>
        <a href="products.php" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>
