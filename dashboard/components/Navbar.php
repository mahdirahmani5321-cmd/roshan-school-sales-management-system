
<div class="custom-container">
    <nav class="navbar navbar-primary bg-body-tertiary fixed-top">
        <div class="container-fluid">

            <!-- Brand -->
            <a class="navbar-brand d-block d-md-none text-capitalize" href="./">👋🏻 <?= $_SESSION['username']; ?></a>

            <!-- Toggler: only on md and smaller -->
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar items for md+ (flex in one row) -->
            <div class="d-none d-md-flex flex-nowrap w-100 justify-content-between align-items-center">

                <ul class="navbar-nav flex-row flex-nowrap mb-0">
                    <li class="nav-item me-3"><a class="nav-link fw-bold active text-capitalize" href="./">👋🏻 <?= $_SESSION['username']; ?></a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./">Home</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./users.php">Users</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./students.php">Students</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./product_category.php">Category</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./products.php">Products</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./sales.php">Sales</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./reports.php">Reports</a></li>

                </ul>

                <form class="d-flex flex-nowrap" action="./logout.php">
                    <button class="btn btn-sm btn-danger" type="submit">Logout</button>
                </form>

            </div>

            <!-- Offcanvas for md- screens -->
            <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">RSSMS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item me-3"><a class="nav-link" href="./">Home</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./users.php">Users</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./students.php">Students</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./product_category.php">Category</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./products.php">Products</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./sales.php">Sales</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="./reports.php">Reports</a></li>
                    </ul>
                    <form class="d-flex mt-3"  action="./logout.php">
                        <button class="btn btn-danger form-control" type="submit">Logout</button>
                    </form>
                </div>
            </div>

        </div>
    </nav>
</div>

    <br><br><br>


 