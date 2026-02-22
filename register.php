<?php
include 'db.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,"INSERT INTO users (username,password) 
    VALUES('$username','$password')");

    echo "<script>alert('User Registered Successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <div class="form-box">
        <h2>User Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button name="register">Register</button>
        </form>
        <div class="form-link">
    Already have an account? 
    <a href="login.php">Login Here</a>
</div>
    </div>
</div>

</body>
</html>