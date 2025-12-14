<?php include("./components/Head.php") ?>

<div class="custom-container">
    <?php include("./components/Navbar.php") ?>
</div>

<?php 
    include "./components/connection.php"; // your database connection

    // Fetch all users
    $queryAllUsers = "SELECT user_id, name, lastname, status, email FROM users WHERE status='active' ORDER BY user_id ASC";
    $result = mysqli_query($conn, $queryAllUsers);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }


 
?>

<div class="container mt-5">
    <h1 class="d-flex justify-content-between align-items-center">
        <span class="text-muted p-2">Users Management</span>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle"></i> Add User
        </button>
    </h1>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']." ".$row['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['user_id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete Button -->
                                <a href="./users_functions.php?delete_id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to deactivate this user?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="./users_functions.php" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['user_id']; ?>">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label">First Name</label>
                                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($row['lastname']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="edit_user" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add NEW USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="./users_functions.php" method="POST" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Row 1: First Name + Last Name -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">First Name</label>
                            <input type="text" name="name" placeholder="Your Name" class="form-control" required>
                            <div class="invalid-feedback">First name is required</div>
                        </div>
                        <div class="col">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastname" placeholder="Your lastname" class="form-control" required>
                            <div class="invalid-feedback">Last name is required</div>
                        </div>
                    </div>
                    <!-- Row 3: Email + Status -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" placeholder="your.mail@gmail.com" class="form-control" required>
                            <div class="invalid-feedback">Valid email is required</div>
                        </div>
                        <div class="col">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Select status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">Please select status</div>
                        </div>
                    </div>

                    <!-- Row 2: Password + Confirm Password -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" placeholder="Your Password" id="password" class="form-control" required>
                            <div class="invalid-feedback">Password is required</div>
                        </div>
                        <div class="col">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" placeholder="Type again your password" id="confirm_password" class="form-control" required>
                            <div class="invalid-feedback">Passwords must match</div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_user" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 validation script -->
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                // Check password match
                const pwd = form.querySelector('#password');
                const confirmPwd = form.querySelector('#confirm_password');
                if (pwd.value !== confirmPwd.value) {
                    confirmPwd.setCustomValidity("Passwords do not match");
                } else {
                    confirmPwd.setCustomValidity("");
                }

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
