<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $category_name = $_POST['name'];
    mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$category_name')");
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">Sole Mates</div>
    
    <div class="form-container">
        <h2>Add a Category</h2>
        <form action="" method="post">
            <label for="name">Category Name</label>
            <input type="text" id="name" name="name" required>
            <button type="submit" name="submit">Add Category</button>
        </form>
        
        <div class="link-to-product-details">
            <a href="index.php">Back to Add Product</a>
        </div>
    </div>
</body>
</html>