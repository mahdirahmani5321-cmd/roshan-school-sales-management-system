<?php include("./components/Head.php") ?>

<div class="custom-container">
    <?php include("./components/Navbar.php") ?>
</div>

<?php 
    include "./components/connection.php";

    // Fetch counts for dashboard
    $userCountQuery = "SELECT COUNT(*) AS total_users FROM users";
    $studentCountQuery = "SELECT COUNT(*) AS total_students FROM students";
    $productCountQuery = "SELECT COUNT(*) AS total_products FROM products";
    $categoryCountQuery = "SELECT COUNT(*) AS total_categories FROM product_categories";

    $userCount = mysqli_fetch_assoc(mysqli_query($conn, $userCountQuery))['total_users'];
    $studentCount = mysqli_fetch_assoc(mysqli_query($conn, $studentCountQuery))['total_students'];
    $productCount = mysqli_fetch_assoc(mysqli_query($conn, $productCountQuery))['total_products'];
    $categoryCount = mysqli_fetch_assoc(mysqli_query($conn, $categoryCountQuery))['total_categories'];
?>

<div class="container mt-5">
    <h1 class="mb-4">
        Dashboard
    </h1>

    <div class="row g-4">
        <!-- Users Card -->
        <div class="col-md-3">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Users</h5>
                        <h2 class="card-text"><?= $userCount; ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-people-fill fs-1"></i>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="./users.php" class="text-white text-decoration-none">View Details</a>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Students</h5>
                        <h2 class="card-text"><?= $studentCount; ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-mortarboard-fill fs-1"></i>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="./students.php" class="text-white text-decoration-none">View Details</a>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Products</h5>
                        <h2 class="card-text"><?= $productCount; ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-box-seam fs-1"></i>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="./products.php" class="text-white text-decoration-none">View Details</a>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Categories</h5>
                        <h2 class="card-text"><?= $categoryCount; ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-tags-fill fs-1"></i>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="./product_category.php" class="text-white text-decoration-none">View Details</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links / Shortcuts -->
    <div class="row mt-5">
        <div class="col-md-3">
            <a href="./products.php" class="btn btn-primary w-100 py-3 shadow-sm mb-3">
                <i class="bi bi-box-seam me-2"></i> Manage Products
            </a>
        </div>
        <div class="col-md-3">
            <a href="./students.php" class="btn btn-success w-100 py-3 shadow-sm mb-3">
                <i class="bi bi-mortarboard-fill me-2"></i> Manage Students
            </a>
        </div>
        <div class="col-md-3">
            <a href="./users.php" class="btn btn-info w-100 py-3 shadow-sm mb-3">
                <i class="bi bi-people-fill me-2"></i> Manage Users
            </a>
        </div>
        <div class="col-md-3">
            <a href="./product_category.php" class="btn btn-danger w-100 py-3 shadow-sm mb-3">
                <i class="bi bi-tags-fill me-2"></i> Manage Categories
            </a>
        </div>
    </div>
</div>

<?php include("./components/Foot.php") ?>
