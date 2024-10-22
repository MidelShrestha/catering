<?php
session_start();
include("connection.php");

// Check if user is already logged in
// if (isset($_SESSION['username'])) {
//     // Redirect based on role
//     if ($_SESSION['role'] == 'admin') {
//         header("Location: admin.php");
//         exit();
//     } else {
//         header("Location: customer.php");
//         exit();
//     }
// }

if (isset($_POST['Login'])) {  
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Successful login
            // Start the session if not already started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['username'] = $email; 
            $_SESSION['role'] = $user['role']; 


            if ($_SESSION['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: customer.php");
            }
            exit();
        } else {
            echo "<p style='color:red;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;'>No user found with that email.</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
    <div class="box">
        <div class="form">
            <h2>Login Here</h2>
            <form method="POST" action="login.php">
                <input type="email" name="email" placeholder="Enter Email Here" required>
                <input type="password" name="password" placeholder="Enter Password Here" required>
                <button class="btnn" type="submit" name="Login">Login</button>
            </form>
            <p class="link">Don't have an account?<br>
                <a href="register.php">Register</a>
            </p>
        </div>
    </div>
</body>
</html>
