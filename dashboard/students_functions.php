<?php

    include_once "./components/connection.php";
    // Handle delete (set inactive)
    if (isset($_GET['delete_id'])) {
        $delete_id = (int)$_GET['delete_id'];
        $update = "UPDATE students SET status='inactive' WHERE student_id=$delete_id";
        mysqli_query($conn, $update);
        header("Location: ./students.php");
        exit;
    }
 
    // Handle edit student submission
    if (isset($_POST['edit_student'])) {
        $student_id = (int)$_POST['student_id'];
        $student_code = mysqli_real_escape_string($conn, $_POST['student_code']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $class = mysqli_real_escape_string($conn, $_POST['class']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $update = "UPDATE students 
                SET student_code='$student_code', full_name='$full_name', class='$class', phone='$phone', status='$status' 
                WHERE student_id=$student_id";
        mysqli_query($conn, $update);
        header("Location: ./students.php");
        exit;
    }

    // Handle add new student
    if (isset($_POST['add_student'])) {
        // Sanitize input
        $student_code = mysqli_real_escape_string($conn, $_POST['student_code']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $class = mysqli_real_escape_string($conn, $_POST['class']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        // Insert query
        $insert = "INSERT INTO students 
                (student_code, full_name, class, phone, status)
                VALUES 
                ('$student_code', '$full_name', '$class', '$phone', '$status')";

        if (mysqli_query($conn, $insert)) {
            // Redirect to students page after adding
            header("Location: ./students.php");
            exit;
        } else {
            die("Error adding student: " . mysqli_error($conn));
        }
    }
?>