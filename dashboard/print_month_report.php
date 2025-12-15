<?php
include "./components/connection.php";

$month = $_GET['month'];

$q = "
SELECT 
    si.invoice_number,
    s.full_name,
    SUM(si.total_price) total
FROM sale_items si
JOIN students s ON si.student_id = s.student_id
WHERE DATE_FORMAT(si.sale_date,'%Y-%m')='$month'
GROUP BY si.invoice_number
";

$res = mysqli_query($conn, $q);
?>

<h2>Sales Report - <?= $month; ?></h2>

<table border="1" width="100%" cellpadding="8">
<tr>
    <th>Invoice</th><th>Student</th><th>Total</th>
</tr>

<?php while ($r = mysqli_fetch_assoc($res)): ?>
<tr>
    <td><?= $r['invoice_number']; ?></td>
    <td><?= $r['full_name']; ?></td>
    <td><?= number_format($r['total'],2); ?> Af</td>
</tr>
<?php endwhile; ?>
</table>

<script>
    window.print();

    // Redirect back after printing or canceling
    window.onafterprint = function() {
        window.location.href = "reports.php";
    };
</script>
