<?php include("./components/Head.php") ?>

<div class="custom-container">
    <?php include("./components/Navbar.php") ?>
</div>


<?php 
    include "./components/connection.php"; // your database connection

    // Fetch all users
    $queryAllStudeents = "SELECT student_id, student_code, full_name, class, phone, status FROM students WHERE status='active'  ORDER BY student_id ASC";
    $result = mysqli_query($conn, $queryAllStudeents);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }


 
?>

<div class="container mt-5">
    <h1 class="d-flex justify-content-between align-items-center">
        <span class="text-muted p-2">Students Management</span>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="bi bi-plus-circle"></i> Add Student
        </button>
    </h1>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>CODE</th>
                    <th>Full Name</th>
                    <th>Class</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['student_code']); ?></td>
                            <td><?= htmlspecialchars($row['full_name']); ?></td>
                            <td><?= htmlspecialchars($row['class']); ?></td>
                            <td><?= htmlspecialchars($row['phone']); ?></td>
                            <td><?= htmlspecialchars($row['status']); ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['student_id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete Button -->
                                <a href="./students_functions.php?delete_id=<?= $row['student_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to deactivate this student?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row['student_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['student_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="./students_functions.php" method="POST" class="needs-validation" novalidate>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $row['student_id']; ?>">Edit Student</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="student_id" value="<?= $row['student_id']; ?>">

                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Student Code</label>
                                                    <input type="text" name="student_code" class="form-control" value="<?= htmlspecialchars($row['student_code']); ?>" required>
                                                    <div class="invalid-feedback">Student code is required</div>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($row['full_name']); ?>" required>
                                                    <div class="invalid-feedback">Full name is required</div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Class</label>
                                                    <select name="class" class="form-select" required>
                                                        <option value="">Select class</option>
                                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                                            <option value="<?= $i; ?>" <?= ($row['class'] == $i) ? 'selected' : ''; ?>>
                                                                <?= $i; ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <div class="invalid-feedback">Class is required</div>
                                                </div>

                                                <div class="col">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($row['phone']); ?>" required>
                                                    <div class="invalid-feedback">Phone is required</div>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="active" <?= $row['status']=='active' ? 'selected':''; ?>>Active</option>
                                                        <option value="inactive" <?= $row['status']=='inactive' ? 'selected':''; ?>>Inactive</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select status</div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="edit_student" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No students found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add NEW STUDENT MODAL -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="./students_functions.php" method="POST" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Row 1: Student Code + Full Name -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Student Code</label>
                            <input type="text" name="student_code" class="form-control" placeholder="Student code" required>
                            <div class="invalid-feedback">Student code is required</div>
                        </div>
                        <div class="col">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Full name" required>
                            <div class="invalid-feedback">Full name is required</div>
                        </div>
                    </div>

                    <!-- Row 2: Class + Phone + Status -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Class</label>
                            <select name="class" class="form-select" required>
                                <option value="">Select class</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="invalid-feedback">Class is required</div>
                        </div>
                        <div class="col">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                            <div class="invalid-feedback">Phone is required</div>
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_student" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
