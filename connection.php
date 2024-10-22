<?php
    $servername= "localhost";
    $username= "root";
    $password= "";
    $dbname= "catering_project";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die(mysqli_error($conn));
    }
    
?>    
