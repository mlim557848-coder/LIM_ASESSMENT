<?php
include "../db.php";

$booking_id = (int)$_GET['booking_id'];

$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id = $booking_id"));

$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id = $booking_id"));
$total_paid = $paidRow['paid'] ?? 0;

$balance = $booking['total_cost'] - $total_paid;

$message = "";
if (isset($_POST['pay'])) {
    $amount = (float)$_POST['amount_paid'];
    $method = mysqli_real_escape_string($conn, $_POST['method']);

    if ($amount <= 0) {
        $message = "Invalid amount!";
    } else if ($amount > $balance + 0.01) {
        $message = "Amount exceeds balance!";
    } else {
        mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method) 
                             VALUES ($booking_id, $amount, '$method')");

        $new_paid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id = $booking_id"))['paid'];
        $new_balance = $booking['total_cost'] - $new_paid;

        if ($new_balance <= 0.01) {
            mysqli_query($conn, "UPDATE bookings SET status = 'PAID' WHERE booking_id = $booking_id");
        }

        header("Location: bookings_list.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="page-container">
    <div class="form-container">
        <h2 class="clients-heading">Process Payment</h2>
        <p class="text-center text-muted mb-4">Booking #<?= $booking_id ?></p>

        <div class="payment-summary">
            <div class="item">
                <span class="label">Total Cost</span>
                <span class="value">₱<?= number_format($booking['total_cost'], 2) ?></span>
            </div>
            <div class="item">
                <span class="label">Total Paid</span>
                <span class="value text-success">₱<?= number_format($total_paid, 2) ?></span>
            </div>
            <hr>
            <div class="item align-items-center">
                <span class="fw-bold fs-5">Balance Due</span>
                <span class="balance">₱<?= number_format($balance, 2) ?></span>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Amount Paid <span class="required">*</span></label>
                <input type="number" name="amount_paid" step="0.01" min="0.01" max="<?= $balance ?>" 
                       class="form-control" placeholder="0.00" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Payment Method <span class="required">*</span></label>
                <select name="method" class="form-select" required>
                    <option value="CASH">Cash</option>
                    <option value="GCASH">GCash</option>
                    <option value="CARD">Card</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="bookings_list.php" class="btn btn-outline-secondary btn-lg">Cancel</a>
                <button type="submit" name="pay" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-1"></i> Save Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>