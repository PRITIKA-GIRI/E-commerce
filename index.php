<?php include 'config.php'; 

if(isset($_POST['submit'])){
    $error = array();
    $product_Name = isset($_POST['name']) ? $_POST['name'] : '';
    $product_Price = isset($_POST['price']) ? $_POST['price'] : '';
    
    if(empty($product_Name)){
        $error[] = 'Please enter product name';
    }
    
    if(empty($product_Price)){
        $error[] = 'Please enter product price';
    }
    
    if(!is_dir(UPLOAD_DIR)){ 
        mkdir(UPLOAD_DIR, 0777, true);
    }
    
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $tmp = explode(".", $file_name);
    $file_ext = end($tmp);
    
    if(empty($error)){
        $insert_product = mysqli_query($conn, "INSERT INTO products(name, price, image) 
                              VALUES('$product_Name', '$product_Price', '$file_name')");
        
        if($insert_product == 1){
            move_uploaded_file($file_tmp, UPLOAD_DIR.$file_name);
            $message[] = 'Product added successfully';
        } else {
            $message[] = 'Error adding product';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Save product details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if(isset($message)){ 
        echo '<div class="message">';
        foreach ($message as $msg) { 
            echo '<span>'.$msg.'</span>';
        }
        echo '</div>';
    }
    ?>
    
    <div class="header"> Sole Mates</div>
    
    <div class="form-container">
        <h2>Add a product</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo isset($product_Name) ? $product_Name : ''; ?>">
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" min="0" value="<?php echo isset($product_Price) ? $product_Price : ''; ?>">
            
            <label for="file">Image</label>
            <input type="file" id="file" name="file">
            
            <button type="submit" id="submit" name="submit">Submit</button>
        </form>
        
        <div class="link-to-product-details">
            <a href="display.php">View Products</a>
        </div>
    </div>
</body>
</html>