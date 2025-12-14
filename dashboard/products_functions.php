<?php
    include_once "./components/connection.php";


// ==============================
// IMAGE UPLOAD FUNCTION
// ==============================
function uploadImage($fileInputName, $oldImage = null)
{
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] != 0) {
        return $oldImage; // keep old image
    }

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $fileName = $_FILES[$fileInputName]['name'];
    $fileTmp = $_FILES[$fileInputName]['tmp_name'];
    $fileSize = $_FILES[$fileInputName]['size'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedTypes)) {
        die("Invalid image type. Allowed: JPG, PNG, GIF");
    }

    if ($fileSize > 5 * 1024 * 1024) {
        die("Image size must be less than 2MB");
    }

    $newName = uniqid('product_', true) . '.' . $ext;
    $uploadPath = "./uploads/" . $newName;

    if (move_uploaded_file($fileTmp, $uploadPath)) {
        // delete old image if exists
        if ($oldImage && file_exists("./uploads/" . $oldImage)) {
            unlink("./uploads/" . $oldImage);
        }
        return $newName;
    }

    return $oldImage;
}

// ==============================
// ADD PRODUCT
// ==============================
if (isset($_POST['add_product'])) {

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category_id = (int)$_POST['category_id'];
    $price = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $photo = uploadImage('photo');

    $query = "
        INSERT INTO products 
        (category_id, product_name, price, stock_quantity, photo, status)
        VALUES
        ('$category_id', '$product_name', '$price', '$stock_quantity', '$photo', '$status')
    ";

    mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: products.php");
    exit;
}

// ==============================
// EDIT PRODUCT
// ==============================
if (isset($_POST['edit_product'])) {

    $product_id = (int)$_POST['product_id'];
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category_id = (int)$_POST['category_id'];
    $price = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // get old photo
    $res = mysqli_query($conn, "SELECT photo FROM products WHERE product_id = $product_id");
    $row = mysqli_fetch_assoc($res);
    $oldPhoto = $row['photo'] ?? null;

    $photo = uploadImage('photo', $oldPhoto);

    $query = "
        UPDATE products SET
            category_id = '$category_id',
            product_name = '$product_name',
            price = '$price',
            stock_quantity = '$stock_quantity',
            photo = '$photo',
            status = '$status'
        WHERE product_id = $product_id
    ";

    mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: products.php");
    exit;
}

// ==============================
// DEACTIVATE PRODUCT (SOFT DELETE)
// ==============================
if (isset($_GET['delete_id'])) {

    $product_id = (int)$_GET['delete_id'];

    // 1. Get image name first
    $result = mysqli_query(
        $conn,
        "SELECT photo FROM products WHERE product_id = $product_id"
    );

    if ($row = mysqli_fetch_assoc($result)) {

        // 2. Delete image file if exists
        if (!empty($row['photo'])) {
            $imagePath = "./uploads/" . $row['photo'];

            if (file_exists($imagePath)) {
                unlink($imagePath); // DELETE IMAGE
            }
        }
    }

    // 3. Delete product record
    mysqli_query(
        $conn,
        "DELETE FROM products WHERE product_id = $product_id"
    ) or die(mysqli_error($conn));

    // 4. Redirect
    header("Location: products.php");
    exit;
}


?>
