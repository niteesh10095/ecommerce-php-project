<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
}

// Add Product
if(isset($_POST['add'])){
    $name=$_POST['name'];
    $price=$_POST['price'];
    $category=$_POST['category'];

    $image = time() . "_" . $_FILES['image']['name'];
    $target = "uploads/" . $image;

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    mysqli_query($conn,"INSERT INTO products(name,price,category,image)
    VALUES('$name','$price','$category','$image')");
}

// Dashboard Stats
$product_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products"));
$order_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM orders"));

$revenue_query = mysqli_query($conn,"SELECT SUM(total_amount) as total FROM orders");
$revenue_data = mysqli_fetch_assoc($revenue_query);
$total_revenue = $revenue_data['total'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="admin-dashboard">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#">Dashboard</a>
        <a href="#">Products</a>
        <a href="#">Orders</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <h2>Welcome, <?php echo $_SESSION['admin']; ?> 👋</h2>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Products</h3>
                <p><?php echo $product_count; ?></p>
            </div>

            <div class="card">
                <h3>Total Orders</h3>
                <p><?php echo $order_count; ?></p>
            </div>

            <div class="card">
                <h3>Total Revenue</h3>
                <p>₹ <?php echo $total_revenue; ?></p>
            </div>
        </div>

        <hr>

        <h3>Add Product</h3>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required><br><br>
            <input type="number" name="price" placeholder="Price" required><br><br>
            <input type="text" name="category" placeholder="Category" required><br><br>
            <input type="file" name="image" required><br><br>
            <button name="add">Add Product</button>
        </form>

        <hr>

        <h3>All Products</h3>

        <table class="admin-table">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Action</th>
            </tr>

            <?php
            $result=mysqli_query($conn,"SELECT * FROM products");
            while($row=mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td>₹ <?php echo $row['price']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>"></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete_product.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <hr>

<div class="order-section">
<h3>📦 Orders Management</h3>

<?php
$order_query = mysqli_query($conn,"
SELECT orders.*, users.username 
FROM orders 
JOIN users ON orders.user_id = users.id
ORDER BY order_date DESC
");
?>

<table class="order-table">
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Phone</th>
<th>Address</th>
<th>Total</th>
<th>Date</th>
</tr>

<?php while($order = mysqli_fetch_assoc($order_query)){ ?>

<tr>
<td><?php echo $order['id']; ?></td>
<td><?php echo $order['username']; ?></td>
<td><?php echo $order['phone']; ?></td>
<td class="address-cell"><?php echo $order['address']; ?></td>
<td>₹ <?php echo $order['total_amount']; ?></td>
<td><?php echo $order['order_date']; ?></td>
</tr>

<?php } ?>

</table>
</div>
    </div>
</div>

</body>
</html>