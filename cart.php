<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,"
SELECT cart.*, products.name, products.price 
FROM cart 
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="cart-container">

<h2 class="cart-title">🛒 Your Shopping Cart</h2>

<?php if(mysqli_num_rows($result) > 0){ ?>

<table class="cart-table">
<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){
$subtotal = $row['price'] * $row['quantity'];
$total += $subtotal;
?>

<tr>
<td><?php echo $row['name']; ?></td>
<td>₹ <?php echo $row['price']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td>₹ <?php echo $subtotal; ?></td>
</tr>

<?php } ?>

<tr class="cart-total-row">
<td colspan="3">Total</td>
<td>₹ <?php echo $total; ?></td>
</tr>

</table>

<a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>

<?php } else { ?>

<div class="empty-cart">
    Your cart is empty 😔
</div>

<?php } ?>

</div>

</body>
</html>