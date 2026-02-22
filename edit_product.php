<?php
include 'db.php';

$id=$_GET['id'];
$result=mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
$row=mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name=$_POST['name'];
    $price=$_POST['price'];
    $category=$_POST['category'];

    mysqli_query($conn,"UPDATE products SET 
    name='$name',price='$price',category='$category'
    WHERE id=$id");

    header("Location: admin_dashboard.php");
}
?>

<form method="POST">
<input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
<input type="number" name="price" value="<?php echo $row['price']; ?>"><br><br>
<input type="text" name="category" value="<?php echo $row['category']; ?>"><br><br>
<button name="update">Update</button>
</form>