<?php
include "./components/connection.php";

$invoice = $_GET['invoice'];

$query = "
SELECT 
    si.*, 
    p.product_name,
    s.full_name AS student_name
FROM sale_items si
LEFT JOIN products p ON si.product_id = p.product_id
LEFT JOIN students s ON si.student_id = s.student_id
WHERE si.invoice_number = '$invoice'
";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
mysqli_data_seek($result, 0);
?>

<h2>Invoice: <?= $invoice ?></h2>
<p>Student: <?= $data['student_name'] ?></p>

<table border="1" width="100%">
<tr>
    <th>Product</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Total</th>
</tr>

<?php $grand = 0; ?>
<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['product_name'] ?></td>
    <td><?= $row['quantity'] ?></td>
    <td><?= $row['unit_price'] ?></td>
    <td><?= $row['total_price'] ?></td>
</tr>
<?php $grand += $row['total_price']; ?>
<?php endwhile; ?>

<tr>
    <td colspan="3"><strong>Grand Total</strong></td>
    <td><strong><?= $grand ?> Af</strong></td>
</tr>
</table>

<a href="invoice_print.php?invoice=<?= $invoice ?>">Print Invoice</a>
