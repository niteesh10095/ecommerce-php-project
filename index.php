<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>ONLINE E-COMMERCE STORE</h1>
    <div>
        <a href="cart.php">Cart</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Search -->
<div class="search-box">
    <form method="GET">
        <input type="text" name="search" placeholder="Search Product">
        <button>Search</button>
    </form>
</div>

<!-- Products -->
<div class="product-container">

<?php

if(isset($_GET['search'])){
    $search=$_GET['search'];
    $result=mysqli_query($conn,"SELECT * FROM products 
    WHERE name LIKE '%$search%'");
}else{
    $result=mysqli_query($conn,"SELECT * FROM products");
}

while($row=mysqli_fetch_assoc($result)){
?>

<div class="product-card">
    <img src="uploads/<?php echo $row['image']; ?>">
    <h3><?php echo $row['name']; ?></h3>
    <p>₹ <?php echo $row['price']; ?></p>

    <form method="POST" action="add_to_cart.php">
        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
        <input type="number" name="quantity" value="1" min="1" style="width:60px;">
        <button type="submit">Add to Cart</button>
    </form>
</div>

<?php } ?>

</div>

</body>
</html>