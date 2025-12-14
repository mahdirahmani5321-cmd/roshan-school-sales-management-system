<?php include("./components/Head.php") ?>

<div class="custom-container">
    <?php include("./components/Navbar.php") ?>
</div>

<?php 
include "./components/connection.php"; // your database connection

// Fetch all product categories
$queryAllCategories = "SELECT * FROM product_categories ORDER BY category_id ASC";
$result = mysqli_query($conn, $queryAllCategories);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<div class="container mt-5">
    <h1 class="d-flex justify-content-between align-items-center">
        <span class="text-muted p-2">Product Categories Management</span>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-circle"></i> Add Category
        </button>
    </h1>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['category_name']); ?></td>
                            <td><?= htmlspecialchars($row['description']); ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['category_id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete Button -->
                                <a href="./categories_functions.php?delete_id=<?= $row['category_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to deactivate this category?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row['category_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['category_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="./categories_functions.php" method="POST" class="needs-validation" novalidate>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $row['category_id']; ?>">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="category_id" value="<?= $row['category_id']; ?>">

                                            <div class="mb-3">
                                                <label class="form-label">Category Name</label>
                                                <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($row['category_name']); ?>" required>
                                                <div class="invalid-feedback">Category name is required</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control" required><?= htmlspecialchars($row['description']); ?></textarea>
                                                <div class="invalid-feedback">Description is required</div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="edit_category" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No categories found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add NEW CATEGORY MODAL -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="./categories_functions.php" method="POST" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" placeholder="Category name" required>
                        <div class="invalid-feedback">Category name is required</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Description" required></textarea>
                        <div class="invalid-feedback">Description is required</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_category" class="btn btn-primary">Save Changes</button>
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
