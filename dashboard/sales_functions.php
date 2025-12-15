<?php

    include_once "./components/connection.php";
    session_start();

    /* ============================
    SELL ITEM
    ============================ */
    if (isset($_POST['sell_item'])) {

        // Logged-in user (seller)
        if (!isset($_SESSION['user_id'])) {
            die("Unauthorized access");
        }

        $user_id = (int) $_SESSION['user_id'];

        // Sanitize inputs
        $student_id     = (int) $_POST['student_id'];
        $product_id     = (int) $_POST['product_id'];
        $quantity       = (int) $_POST['quantity'];
        $unit_price     = (float) $_POST['unit_price'];
        $discount       = (float) $_POST['discount'];
        $total_price    = (float) $_POST['total_price'];
        $invoice_number = mysqli_real_escape_string($conn, $_POST['invoice_number']);

        // ============================
        // CHECK PRODUCT STOCK
        // ============================
        $productQuery = mysqli_query(
            $conn,
            "SELECT stock_quantity FROM products WHERE product_id = $product_id"
        );

        if (mysqli_num_rows($productQuery) == 0) {
            die("Product not found");
        }

        $product = mysqli_fetch_assoc($productQuery);

        if ($quantity > $product['stock_quantity']) {
            die("Not enough stock available");
        }

        // ============================
        // INSERT SALE
        // ============================
        $insertSale = "
            INSERT INTO sale_items (
                product_id,
                quantity,
                unit_price,
                discount,
                total_price,
                invoice_number,
                student_id,
                user_id,
                sale_date
            ) VALUES (
                $product_id,
                $quantity,
                $unit_price,
                $discount,
                $total_price,
                '$invoice_number',
                $student_id,
                $user_id,
                NOW()
            )
        ";

        if (!mysqli_query($conn, $insertSale)) {
            die("Sale insert failed: " . mysqli_error($conn));
        }

        // ============================
        // UPDATE PRODUCT STOCK
        // ============================
        $updateStock = "
            UPDATE products
            SET stock_quantity = stock_quantity - $quantity
            WHERE product_id = $product_id
        ";

        mysqli_query($conn, $updateStock) or die(mysqli_error($conn));

        // ============================
        // REDIRECT
        // ============================
        header("Location: ./sales.php?success=1");
        exit;
    }


    if (isset($_GET['refund'])) {

        $id = (int)$_GET['refund'];

        $sale = mysqli_fetch_assoc(
            mysqli_query($conn, "SELECT * FROM sale_items WHERE sale_item_id=$id")
        );

        // restore stock
        mysqli_query($conn, "
            DELETE FROM sale_items WHERE sale_item_id = '$id'
        ");

   

        header("Location: ./sales.php");
    }



?>