<?php

    include_once "./components/connection.php";
   // Handle delete action
    if (isset($_GET['delete_id'])) {
        $delete_id = (int)$_GET['delete_id'];
        $update = "UPDATE users SET status='inactive' WHERE user_id=$delete_id";
        mysqli_query($conn, $update);
        header("Location: ./users.php");
        exit;
    }

    // Handle edit form submission
    if (isset($_POST['edit_user'])) {
        $user_id = (int)$_POST['user_id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $update = "UPDATE users SET name='$name', lastname='$lastname', email='$email' WHERE user_id=$user_id";
        mysqli_query($conn, $update);
        header("Location: ./users.php");
        exit;
    }


    // Handle add new user form submission
    if (isset($_POST['add_user'])) {

        // Sanitize input
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Optional: hash the password
        $password_hashed = md5($password); // use password_hash() for better security in production

        // Insert query
        $insert = "
            INSERT INTO users (name, lastname, email, password, status)
            VALUES ('$name', '$lastname', '$email', '$password_hashed', '$status')
        ";

        if (mysqli_query($conn, $insert)) {
            // Redirect back to users page
            header("Location: ./users.php");
            exit;
        } else {
            die("Error adding user: " . mysqli_error($conn));
        }
    }

?>