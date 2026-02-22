<?php
include 'db.php';

if(isset($_POST['register'])){
    $username=$_POST['username'];
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

    mysqli_query($conn,"INSERT INTO admins (username,password) 
    VALUES('$username','$password')");

    echo "<script>alert('Admin Registered Successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

<div class="form-container">
    <div class="admin-box">
        <h2>Admin Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Admin Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button name="register">Register</button>
        </form>
<div class="form-link">
    Already have an account? 
    <a href="admin_login.php">Admin Login Here</a>
</div>
    </div>
</div>

</body>
</html>