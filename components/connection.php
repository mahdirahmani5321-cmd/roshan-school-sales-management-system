<?php
    $host     = "localhost";
    $username = "root";
    $password = "";
    $database = "rssms";

    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die(
            "❌ Database connection failed"
        );
    }
?>
