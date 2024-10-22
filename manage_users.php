<?php
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <a href="add_users.php" class="btn btn-primary my-5 text-light">Add User</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th> 
                    <th scope="col">Role</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `users`";
                $result = mysqli_query($conn, $sql);
                if($result){
                    while($row = mysqli_fetch_assoc($result)){
                        $id = $row['id'];
                        $username = $row['name'];
                        $email = $row['email'];
                        $password = $row['password'];
                        $role = $row['role'];

                        echo '<tr>
                            <th scope="row">'.($id).'</th>
                            <td>'.($username).'</td>
                            <td>'.($email).'</td>
                            <td>********</td>  <!-- Mask the password -->
                            <td>'.($role).'</td>
                            <td>
                                <a href="update_user.php?id='.$id.'" class="btn btn-primary">Update</a>
                                <a href="delete_user.php?id='.$id.'" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>';
                    }
                } else {
                    echo "Error fetching users: " . mysqli_error($conn);
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
