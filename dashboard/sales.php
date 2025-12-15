<?php include("./components/Head.php") ?>

<div class="custom-container">
    <?php include("./components/Navbar.php") ?>
</div>

<?php
include "./components/connection.php";

        /* ===========================
            FETCH STUDENT SALES
        =========================== */
        $salesQuery = "
            SELECT 
                si.invoice_number,
                si.sale_item_id,
                p.product_name,
                p.photo,
                s.full_name AS student_name,
                CONCAT(u.name, ' ', u.lastname) AS sold_by,
                SUM(si.quantity) AS total_items,
                SUM(si.total_price) AS grand_total,
                SUM(si.discount) AS total_discount,
                MAX(si.sale_date) AS sale_date
            FROM sale_items si
            LEFT JOIN students s ON si.student_id = s.student_id
            LEFT JOIN users u ON si.user_id = u.user_id
            LEFT JOIN products p ON si.product_id = p.product_id
            GROUP BY si.invoice_number
            ORDER BY sale_date DESC
        ";

        $salesResult = mysqli_query($conn, $salesQuery) or die(mysqli_error($conn));
        $students = mysqli_query($conn, "SELECT student_id, full_name FROM students ORDER BY full_name");
        $products = mysqli_query($conn, "SELECT product_id, product_name, price, stock_quantity FROM products WHERE status='active'");
        // Generate incremental invoice number
        $invoiceQuery = mysqli_query($conn, "SELECT invoice_number FROM sale_items ORDER BY sale_item_id DESC LIMIT 1");

        if (mysqli_num_rows($invoiceQuery) > 0) {
            $lastInvoice = mysqli_fetch_assoc($invoiceQuery)['invoice_number'];
            $num = (int) str_replace('INV-', '', $lastInvoice);
            $newInvoice = 'INV-' . str_pad($num + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newInvoice = 'INV-00001';
        }

?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Sales Management</h1>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#sellItemModal">
            <i class="bi bi-cart-plus"></i> Sell New Item
        </button>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Invoice</th>
                    <th>Product</th>
                    <th>Student</th>
                    <th>Total Items</th>
                    <th>Discount</th>
                    <th>Total Amount</th>
                    <th>Sold By</th>
                    <th>Date</th>
                    <th>Refund</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($salesResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($salesResult)): ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">
                                    <?= htmlspecialchars($row['invoice_number']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="text-capitalize fw-bold">
                                    <?= htmlspecialchars($row['product_name']); ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['student_name']); ?></td>
                            <td>
                                <span class="badge bg-info">
                                    <?= $row['total_items']; ?>
                                </span>
                            </td>
                            <td><?= number_format($row['total_discount'], 2); ?> Af</td>
                            <td>
                                <strong><?= number_format($row['grand_total'], 2); ?> Af</strong>
                            </td>
                            <td><?= htmlspecialchars($row['sold_by']); ?></td>
                            <td><?= date("Y-m-d H:i", strtotime($row['sale_date'])); ?></td>
                            <td>
                                <a href="./sales_functions.php?refund=<?= $row['sale_item_id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Refund this item?')">
                                    Refund
                                </a>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No sales found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="sellItemModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="sales_functions.php" method="POST" id="saleForm">

                <div class="modal-header">
                    <h5 class="modal-title">Sell New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- STUDENT + INVOICE -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Student</label>
                            <select name="student_id" class="form-select" required>
                                <option value="">Select Student</option>
                                <?php while ($s = mysqli_fetch_assoc($students)): ?>
                                    <option value="<?= $s['student_id']; ?>">
                                        <?= htmlspecialchars($s['full_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Invoice Number</label>
                            <input type="text"
                                   name="invoice_number"
                                   class="form-control"
                                   value="<?= $newInvoice; ?>"
                                   readonly>
                        </div>
                    </div>

                    <!-- PRODUCT -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Product</label>
                            <select name="product_id"
                                    id="product_id"
                                    class="form-select"
                                    required
                                    onchange="updatePrice()">
                                <option value="">Select Product</option>
                                <?php while ($p = mysqli_fetch_assoc($products)): ?>
                                    <option value="<?= $p['product_id']; ?>"
                                            data-price="<?= $p['price']; ?>"
                                            data-stock="<?= $p['stock_quantity']; ?>">
                                        <?= htmlspecialchars($p['product_name']); ?>
                                        (Stock: <?= $p['stock_quantity']; ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Unit Price</label>
                            <input type="number"
                                   step="0.01"
                                   id="unit_price"
                                   name="unit_price"
                                   class="form-control"
                                   readonly>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Quantity</label>
                            <input type="number"
                                   name="quantity"
                                   id="quantity"
                                   class="form-control"
                                   value="1"
                                   min="1"
                                   required
                                   oninput="calculateTotal()">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Discount</label>
                            <input type="number"
                                   step="0.01"
                                   name="discount"
                                   id="discount"
                                   class="form-control"
                                   value="0"
                                   oninput="calculateTotal()">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Total</label>
                            <input type="number"
                                   step="0.01"
                                   name="total_price"
                                   id="total_price"
                                   class="form-control"
                                   readonly>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="sell_item" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Complete Sale
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    function updatePrice() {
        const product = document.getElementById('product_id');
        const selected = product.options[product.selectedIndex];

        const price = parseFloat(selected.getAttribute('data-price')) || 0;
        const stock = parseInt(selected.getAttribute('data-stock')) || 0;

        document.getElementById('unit_price').value = price;
        document.getElementById('quantity').max = stock;

        calculateTotal();
    }

    function calculateTotal() {
        const price = parseFloat(document.getElementById('unit_price').value) || 0;
        const qty = parseInt(document.getElementById('quantity').value) || 1;
        const discount = parseFloat(document.getElementById('discount').value) || 0;

        let total = (price * qty) - discount;
        if (total < 0) total = 0;

        document.getElementById('total_price').value = total.toFixed(2);
    }
</script>

<?php include("./components/Foot.php") ?>
