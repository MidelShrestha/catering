<?php
include('connection.php');

// Initialize variables
$username = $email = $password = $role = $id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);  // 'i' indicates that $id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $role = $row['role'];
    } else {
        die("User not found.");
    }

    $stmt->close();
}

// Update user data
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Use prepared statement for updating user details
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $username, $email, $password, $role, $id);
    $result = $stmt->execute();

    if ($result) {
        header('Location: customer.php');
        exit();
    } else {
        die('Error updating user: ' . $conn->error);
    }

    $stmt->close();
}

$conn->close();
?>

<!Doctype html>
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
          </select>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Update</button>
      </form>
    </div>
  </body>
</html>
