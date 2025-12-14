<?php include("./components/Head.php") ?>

<div class="custom-container">
    <?php include("./components/Navbar.php") ?>
</div>

<?php
include "./components/connection.php";

/* ===========================
   FETCH PRODUCTS WITH CATEGORY
=========================== */
$queryProducts = "
    SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN product_categories c ON p.category_id = c.category_id
    ORDER BY p.product_id ASC
";
$result = mysqli_query($conn, $queryProducts) or die(mysqli_error($conn));

/* ===========================
   FETCH CATEGORIES
=========================== */
$categories = mysqli_query($conn, "SELECT * FROM product_categories ORDER BY category_name ASC");
?>

<div class="container mt-5">
    <h1 class="d-flex justify-content-between align-items-center">
        <span class="text-muted p-2">Products Management</span>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle"></i> Add Product
        </button>
    </h1>
    <div class="row mb-3">
        <div class="">
            <input type="text"
                id="search"
                class="form-control"
                placeholder="Search product or category...">
        </div>
    </div>


    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Photo</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>

                            <td>
                                <?php if ($row['photo']): ?>
                                    <img src="./uploads/<?= htmlspecialchars($row['photo']); ?>" width="50" height="50" style="object-fit:cover;">
                                <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($row['product_name']); ?></td>
                            <td><?= htmlspecialchars($row['category_name']); ?></td>
                            <td><?= number_format($row['price'], 2); ?>Af</td>
                            <td><?= $row['stock_quantity']; ?></td>

                            <td>
                                <span class="badge bg-<?= $row['status']=='active'?'success':'secondary'; ?>">
                                    <?= ucfirst($row['status']); ?>
                                </span>
                            </td>

                            <td>
                                <button class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal<?= $row['product_id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <a href="./products_functions.php?delete_id=<?= $row['product_id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Deactivate this product?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- =======================
                             EDIT PRODUCT MODAL
                        ======================== -->
                        <div class="modal fade" id="editModal<?= $row['product_id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="./products_functions.php"
                                          method="POST"
                                          enctype="multipart/form-data"
                                          class="needs-validation"
                                          novalidate>

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="product_id" value="<?= $row['product_id']; ?>">

                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Product Name</label>
                                                    <input type="text" name="product_name" class="form-control"
                                                           value="<?= htmlspecialchars($row['product_name']); ?>" required>
                                                </div>

                                                <div class="col">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id" class="form-select" required>
                                                        <?php
                                                        mysqli_data_seek($categories, 0);
                                                        while ($cat = mysqli_fetch_assoc($categories)): ?>
                                                            <option value="<?= $cat['category_id']; ?>"
                                                                <?= $cat['category_id']==$row['category_id']?'selected':''; ?>>
                                                                <?= htmlspecialchars($cat['category_name']); ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Price</label>
                                                    <input type="number" step="0.01" name="price"
                                                           value="<?= $row['price']; ?>" class="form-control" required>
                                                </div>

                                                <div class="col">
                                                    <label class="form-label">Stock</label>
                                                    <input type="number" name="stock_quantity"
                                                           value="<?= $row['stock_quantity']; ?>" class="form-control" required>
                                                </div>

                                                <div class="col">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="active" <?= $row['status']=='active'?'selected':''; ?>>Active</option>
                                                        <option value="inactive" <?= $row['status']=='inactive'?'selected':''; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Change Photo</label>
                                                <input type="file" name="photo" class="form-control">
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="edit_product" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- =======================
        ADD PRODUCT MODAL
    ======================= -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="./products_functions.php"
                    method="POST"
                    enctype="multipart/form-data"
                    class="needs-validation"
                    novalidate>

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name" class="form-control" required>
                            </div>

                            <div class="col">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select category</option>
                                    <?php
                                    mysqli_data_seek($categories, 0);
                                    while ($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?= $cat['category_id']; ?>">
                                            <?= htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>

                            <div class="col">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock_quantity" class="form-control" required>
                            </div>

                            <div class="col">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Photo</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_product" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<script>
    document.getElementById('search').addEventListener('keyup', function () {
        let searchValue = this.value.toLowerCase();
        let tableRows = document.querySelectorAll("tbody tr");

        tableRows.forEach(function (row) {
            let rowText = row.textContent.toLowerCase();
            if (rowText.includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

<?php include("./components/Foot.php") ?>
