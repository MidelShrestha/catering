<?php
include ('connection.php');
if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $role=$_POST['role'];

    $sql="INSERT INTO users (name, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    $result= mysqli_query($conn,$sql);
    if($result){
        //echo "Data inserted successfully";
        header('location:manage_users.php');
    }else{
        die(mysqli_error($conn));
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Add Users</title>
  </head>
  <body>
    <div class="container my-5">
    <form method="POST">
  <div class="mb-3">
    <label for="Username" class="form-label">Username</label>
    <input type="text" class="form-control" placeholder="Enter your name" name="username" autocomplete="off">
  </div>

  <div class="mb-3">
    <label for="Email" class="form-label">Email</label>
    <input type="email" class="form-control" placeholder="Enter your email " name="email"autocomplete="off">
  </div>

  <div class="mb-3">
    <label for="Password" class="form-label">Password</label>
    <input type="password" class="form-control" placeholder="Enter your password" name="password"autocomplete="off">
  </div>

  <div class="mb-3">
    <label for="Role" class="form-label">Role</label>
    <select id="role" name="role" required>
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>
</div>        

  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>
 </div>
  </body>
</html>