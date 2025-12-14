
<?php include("./components/Head.php"); ?>
<?php require_once "./components/connection.php"; ?>


<div class="container-fluid">
    <div class="row justify-content-center " style="height: 100vh;">
        <div class="col-12 col-md-8 col-lg-4" style="margin: auto;">
            <div class="card shadow" >
                <div class="card-body py-5">
                    <h4 class="text-center mb-4">Login</h4>

                        <?php
                            session_start();

                            if (isset($_POST["login-form"])) {

                                $email = $_POST["email"];
                                $password = $_POST["password"];

                                if (empty($email) || empty($password)) {
                                    echo "<div class='alert alert-danger'>Email and password are required</div>";
                                } else {

                                    $query = "SELECT * FROM users WHERE email = '$email' AND password = md5('$password')";

                                    $result = mysqli_query($conn, $query);

                                    if (!$result) {
                                        die("Query error: " . mysqli_error($conn));
                                    }

                                    if (mysqli_num_rows($result) == 1) {

                                        $user = mysqli_fetch_assoc($result);

                                        if($user['status'] == 'active'){
                                            // ✅ Set session
                                            $_SESSION['user_id'] = $user['user_id'];
                                            $_SESSION['user_email'] = $user['email'];
                                            $_SESSION['username'] = $user['name']." ".$user['lastname'];
    
                                            // ✅ Redirect to dashboard
                                            header("Location: dashboard/index.php");
                                            exit;
                                        }else{
                                            echo "<div class='alert alert-danger'>❌ User is not active</div>";
                                        }


                                    } else {
                                        echo "<div class='alert alert-danger'>⚠️ Email or password is wrong</div>";
                                    }
                                }
                            }
                        ?>


                    <form action="#" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" placeholder="Your email like (example@gmail.com)" name="email" class="form-control" required>
                            <div class="invalid-feedback">Please enter a valid email</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" placeholder="Your account password" name="password" class="form-control" required minlength="6">
                            <div class="invalid-feedback">Password must be at least 6 characters</div>
                        </div>

                        <button type="submit" name="login-form" class="btn btn-primary w-100">Login</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap Validation Script -->
<script>
    (() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        form.classList.add('was-validated')
        }, false)
    })
    })()
</script>

<?php include("./components/Foot.php") ?>
