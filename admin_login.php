<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];

    $result=mysqli_query($conn,"SELECT * FROM admins WHERE username='$username'");
    $admin=mysqli_fetch_assoc($result);

    if($admin && password_verify($password,$admin['password'])){
        $_SESSION['admin']=$username;
        header("Location: admin_dashboard.php");
    } else {
        echo "<script>alert('Invalid Admin Credentials!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

<div class="form-container">
    <div class="admin-box">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Admin Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>