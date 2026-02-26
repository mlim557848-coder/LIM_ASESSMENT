<?php
include "../db.php";

$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="page-container">
    <div class="list-header">
        <h2 class="clients-heading">Payments</h2>
    </div>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="empty-state">
            <span class="icon-wrapper"><i class="bi bi-receipt"></i></span>
            <h4>No Payments Yet</h4>
            <p>Payments will appear here once bookings are processed.</p>
        </div>
    <?php else: ?>
        <div class="clients-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Booking</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>#<?= $p['payment_id'] ?></td>
                                <td><?= htmlspecialchars($p['full_name']) ?></td>
                                <td>#<?= $p['booking_id'] ?></td>
                                <td>₱<?= number_format($p['amount_paid'], 2) ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($p['method']) ?></span></td>
                                <td><?= date('M d, Y h:i A', strtotime($p['payment_date'])) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>