    <?php include("./components/Head.php") ?>
    <title>RSSMS</title>
    <!-- Start Navbar -->
    <?php include("./components/Navbar.php") ?>
    <!-- End navbar -->
    <!-- Start Slider -->
    <div class="custom-container">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <!-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./assets/images/28961.jpg" class="d-block w-100 slider-image" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/32058.jpg" class="d-block w-100 slider-image" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- End Slider -->

    <?php include("./components/Foot.php") ?>
