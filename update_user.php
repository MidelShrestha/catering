<?php
include ('connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['name'];
        $email = $row['email'];
        $password = $row['password'];  
        $role = $row['role'];
    } else {
        die(mysqli_error($conn));
    }
}

// Update user data
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // SQL query to update user
    $sql = "UPDATE users SET name = '$username', email = '$email', password = '$password', role = '$role' WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: manage_users.php');
        exit();
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
    <title>Update User</title>
  </head>
  <body>
    <div class="container my-5">
      <form method="POST">
        <div class="mb-3">
          <label for="Username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" autocomplete="off" required>
        </div>

        <div class="mb-3">
          <label for="Email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" autocomplete="off" required>
        </div>

        <div class="mb-3">
          <label for="Password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" autocomplete="off" required>
        </div>

        <div class="mb-3">
          <label for="Role" class="form-label">Role</label>
          <select id="role" name="role" class="form-select" required>
            <option value="customer" <?php if($role == 'customer') echo 'selected'; ?>>Customer</option>
            <option value="admin" <?php if($role == 'admin') echo 'selected'; ?>>Admin</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Update</button>
      </form>
    </div>
  </body>
</html>
