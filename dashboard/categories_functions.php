<?php
include "./components/connection.php";

// ========================
// ADD NEW CATEGORY
// ========================
if (isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $insert = "INSERT INTO product_categories 
               (category_name, description)
               VALUES ('$category_name', '$description')";

    if (mysqli_query($conn, $insert)) {
        header("Location: ./product_category.php");
        exit;
    } else {
        die("Error adding category: " . mysqli_error($conn));
    }
}

// ========================
// EDIT CATEGORY
// ========================
if (isset($_POST['edit_category'])) {
    $category_id = (int)$_POST['category_id'];
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update = "UPDATE product_categories 
               SET category_name='$category_name', description='$description' 
               WHERE category_id=$category_id";

    if (mysqli_query($conn, $update)) {
        header("Location: ./product_category.php");
        exit;
    } else {
        die("Error updating category: " . mysqli_error($conn));
    }
}

// ========================
// DELETE (SET INACTIVE)
// ========================
if (isset($_GET['delete_id'])) {
    $category_id = (int)$_GET['delete_id'];

    // Optional: if you want to use a status column, otherwise we can just delete
    // For now we will just delete the category
    $delete = "DELETE FROM product_categories WHERE category_id=$category_id";

    if (mysqli_query($conn, $delete)) {
        header("Location: ./product_category.php");
        exit;
    } else {
        die("Error deleting category: " . mysqli_error($conn));
    }
}
?>
