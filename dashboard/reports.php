<?php include("./components/Head.php") ?>

<div class="custom-container">
    <?php include("./components/Navbar.php") ?>
</div>

<?php
include "./components/connection.php";

/* ======================
   MONTH FILTER
====================== */
$month = $_GET['month'] ?? date('Y-m');

$where = "";
if ($month) {
    $where = "WHERE DATE_FORMAT(si.sale_date,'%Y-%m')='$month'";
}

/* ======================
   FETCH SALES (INVOICE)
====================== */
$query = "
    SELECT 
        si.invoice_number,
        s.full_name AS student_name,
        CONCAT(u.name,' ',u.lastname) AS sold_by,
        SUM(si.quantity) AS items,
        SUM(si.discount) AS discount,
        SUM(si.total_price) AS total,
        MAX(si.sale_date) AS sale_date
    FROM sale_items si
    JOIN students s ON si.student_id = s.student_id
    JOIN users u ON si.user_id = u.user_id
    $where
    GROUP BY si.invoice_number
    ORDER BY sale_date DESC
";

$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>

<div class="container mt-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Sales Reports</h1>

        <div class="d-flex gap-2">
            <!-- MONTH PICKER -->
            <form method="GET" class="d-flex gap-2">
                <input type="month"
                       name="month"
                       value="<?= $month; ?>"
                       class="form-control"
                       onchange="this.form.submit()">
            </form>

            <!-- PRINT MONTH -->
            <a href="print_month_report.php?month=<?= $month; ?>"
               target="_slef"
               class="btn btn-dark">
                <i class="bi bi-printer"></i> Print Month
            </a>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Invoice</th>
                    <th>Student</th>
                    <th>Items</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Sold By</th>
                    <th>Date</th>
                    <th width="80">Print</th>
                </tr>
            </thead>

            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">
                                    <?= $row['invoice_number']; ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['student_name']); ?></td>
                            <td><?= $row['items']; ?></td>
                            <td><?= number_format($row['discount'],2); ?> Af</td>
                            <td><strong><?= number_format($row['total'],2); ?> Af</strong></td>
                            <td><?= htmlspecialchars($row['sold_by']); ?></td>
                            <td><?= date("Y-m-d", strtotime($row['sale_date'])); ?></td>
                            <td class="text-center">
                                <a href="print_invoice.php?invoice=<?= $row['invoice_number']; ?>"
                                   target="_self"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-printer"></i>
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

<?php include("./components/Foot.php") ?>
