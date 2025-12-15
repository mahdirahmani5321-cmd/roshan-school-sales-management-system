<?php
include "./components/connection.php";

$invoice = $_GET['invoice'];

$q = "
SELECT 
    si.*,
    p.product_name,
    s.full_name AS student
FROM sale_items si
JOIN products p ON si.product_id = p.product_id
JOIN students s ON si.student_id = s.student_id
WHERE si.invoice_number='$invoice'
";

$res = mysqli_query($conn, $q);
$items = [];
while ($r = mysqli_fetch_assoc($res)) $items[] = $r;
?>

<h2>Invoice: <?= $invoice; ?></h2>
<p><strong>Student:</strong> <?= $items[0]['student']; ?></p>

<table border="1" width="100%" cellpadding="8">
<tr>
    <th>Product</th><th>Qty</th><th>Price</th><th>Total</th>
</tr>

<?php foreach ($items as $i): ?>
<tr>
    <td><?= $i['product_name']; ?></td>
    <td><?= $i['quantity']; ?></td>
    <td><?= $i['unit_price']; ?></td>
    <td><?= $i['total_price']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<script>
    window.print();

    // Redirect back after printing or canceling
    window.onafterprint = function() {
        window.location.href = "reports.php";
    };
</script>
