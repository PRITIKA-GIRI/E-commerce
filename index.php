<?php 
include 'config.php';

// Initialize variables
$error = [];
$message = [];
$product_Name = $product_Price = '';

if(isset($_POST['submit'])){
    // Sanitize inputs
    $product_Name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $product_Price = mysqli_real_escape_string($conn, $_POST['price'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    
    // Validation
    if(empty($product_Name)){
        $error[] = 'Please enter product name';
    }
    
    if(empty($product_Price) || !is_numeric($product_Price)){
        $error[] = 'Please enter valid product price';
    }
    
    if($category_id <= 0){
        $error[] = 'Please select a valid category';
    }
    
    // File handling
    if(empty($error)){
        if(!is_dir(UPLOAD_DIR)){ 
            mkdir(UPLOAD_DIR, 0777, true);
        }
        
        $file_name = '';
        if(isset($_FILES['file'])){
            $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_ext;
            $file_tmp = $_FILES['file']['tmp_name'];
            
            if(!move_uploaded_file($file_tmp, UPLOAD_DIR.$file_name)){
                $error[] = 'Failed to upload image';
            }
        } else {
            $error[] = 'Please select an image';
        }
        
        // Insert product with category
        if(empty($error)){
            $insert_query = "INSERT INTO products (name, price, image, category_id) 
                            VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, "sdsi", $product_Name, $product_Price, $file_name, $category_id);
            
            if(mysqli_stmt_execute($stmt)){
                $message[] = 'Product added successfully';
                // Clear form on success
                $product_Name = $product_Price = '';
            } else {
                $error[] = 'Error adding product: ' . mysqli_error($conn);
                // Delete uploaded file if DB insert failed
                if(file_exists(UPLOAD_DIR.$file_name)){
                    unlink(UPLOAD_DIR.$file_name);
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product with Category</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">Sole Mates</div>
    
    <div class="form-container">
        <h2>Add a Product</h2>
        
        <?php
        // Display errors/messages
        if(!empty($error)){
            echo '<div class="message error">';
            foreach($error as $err){
                echo '<span>'.$err.'</span>';
            }
            echo '</div>';
        }
        
        if(!empty($message)){
            echo '<div class="message">';
            foreach($message as $msg){
                echo '<span>'.$msg.'</span>';
            }
            echo '</div>';
        }
        ?>
        
        <form action="" method="post" enctype="multipart/form-data">
            
            <label for="category">Category</label>
            <select id="category" name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php
                $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");
                if(mysqli_num_rows($categories) > 0){
                    while($row = mysqli_fetch_assoc($categories)){
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                } else {
                    echo '<option value="" disabled>No categories found</option>';
                }
                ?>
            </select>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product_Name) ?>" required>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" min="0" step="0.01" 
                   value="<?= htmlspecialchars($product_Price) ?>" required>
            
            <label for="file">Image</label>
            <input type="file" id="file" name="file" accept="image/*" required>
            
            <button type="submit" name="submit">Submit</button>
        </form>
        
        <div class="link-to-product-details">
            <a href="add_category.php">Add New Category</a> |
            <a href="display.php">              View Products</a>
        </div>
    </div>
    
</body>
</html>