<?php
include "../db.php";

$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="page-container">
    <div class="list-header">
        <h2 class="clients-heading">Bookings</h2>
        <a href="bookings_create.php" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-1"></i> Create Booking
        </a>
    </div>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="empty-state">
            <span class="icon-wrapper"><i class="bi bi-calendar-x"></i></span>
            <h4>No Bookings Yet</h4>
            <p>Create your first booking to get started.</p>
            <a href="bookings_create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Create Booking
            </a>
        </div>
    <?php else: ?>
        <div class="clients-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Hours</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="action-cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($b = mysqli_fetch_assoc($result)) { 
                            $statusClass = match(strtoupper($b['status'])) {
                                'PAID'    => 'bg-success',
                                'PENDING' => 'bg-secondary',
                                'PARTIAL' => 'bg-warning',
                                default   => 'bg-secondary'
                            };
                        ?>
                            <tr>
                                <td>#<?= $b['booking_id'] ?></td>
                                <td><?= htmlspecialchars($b['client_name']) ?></td>
                                <td><?= htmlspecialchars($b['service_name']) ?></td>
                                <td><?= date('M d, Y', strtotime($b['booking_date'])) ?></td>
                                <td><?= $b['hours'] ?></td>
                                <td>₱<?= number_format($b['total_cost'], 2) ?></td>
                                <td><span class="badge <?= $statusClass ?>"><?= htmlspecialchars($b['status']) ?></span></td>
                                <td class="action-cell">
                                    <a href="payment_process.php?booking_id=<?= $b['booking_id'] ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-credit-card me-1"></i> Pay
                                    </a>
                                </td>
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