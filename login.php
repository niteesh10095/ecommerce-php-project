<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn,"SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password,$user['password'])){
        $_SESSION['user']=$username;
        $_SESSION['user_id']=$user['id'];
        header("Location: index.php");
    } else {
        echo "<script>alert('Invalid Credentials!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <div class="form-box">
        <h2>User Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>