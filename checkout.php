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
$items = [];

while($row=mysqli_fetch_assoc($result)){
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $items[] = $row;
}

if(isset($_POST['place_order'])){

    $address = $_POST['address'];
    $phone = $_POST['phone'];

    mysqli_query($conn,"INSERT INTO orders(user_id,total_amount,address,phone)
    VALUES('$user_id','$total','$address','$phone')");

    $order_id = mysqli_insert_id($conn);

    foreach($items as $item){
        mysqli_query($conn,"INSERT INTO order_items
        (order_id,product_id,quantity,price)
        VALUES('$order_id',
               '{$item['product_id']}',
               '{$item['quantity']}',
               '{$item['price']}')");
    }

    mysqli_query($conn,"DELETE FROM cart WHERE user_id='$user_id'");

    echo "<script>alert('Order Placed Successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="checkout-container">

<!-- Delivery Form -->
<div class="checkout-form">
<h3>Delivery Details</h3>

<form method="POST">
<textarea name="address" placeholder="Enter Delivery Address" required></textarea>
<input type="text" name="phone" placeholder="Enter Phone Number" required>

<button type="submit" name="place_order" class="place-order-btn">
Place Order
</button>
</form>
</div>

<!-- Order Summary -->
<div class="checkout-summary">
<h3>Order Summary</h3>

<?php foreach($items as $item){ ?>
<p>
<?php echo $item['name']; ?>  
(x<?php echo $item['quantity']; ?>)  
- ₹ <?php echo $item['price'] * $item['quantity']; ?>
</p>
<?php } ?>

<hr>
<h3>Total: ₹ <?php echo $total; ?></h3>

</div>

</div>

</body>
</html>