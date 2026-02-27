<?php
include "db.php";

$clients   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'] ?? 0;
$services  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'] ?? 0;
$bookings  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'] ?? 0;
$revenue   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid), 0) AS s FROM payments"))['s'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalonApp - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<?php include "nav.php"; ?>

<div class="page-container">
    <h1 class="text-center mb-5 fw-bold">Dashboard</h1>

    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-primary h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill text-primary display-4 mb-3"></i>
                    <h5 class="text-muted">Total Clients</h5>
                    <h2 class="fw-bold"><?= number_format($clients) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-success h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-scissors text-success display-4 mb-3"></i>
                    <h5 class="text-muted">Total Services</h5>
                    <h2 class="fw-bold"><?= number_format($services) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-warning h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-calendar-check text-warning display-4 mb-3"></i>
                    <h5 class="text-muted">Total Bookings</h5>
                    <h2 class="fw-bold"><?= number_format($bookings) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-danger h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-currency-peso text-danger display-4 mb-3"></i>
                    <h5 class="text-muted">Total Revenue</h5>
                    <h2 class="fw-bold">₱<?= number_format($revenue, 2) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <h4 class="mb-4 fw-semibold">Quick Actions</h4>
        <a href="pages/clients_add.php" class="btn btn-outline-primary btn-lg mx-2">Add Client</a>
        <a href="pages/services_add.php" class="btn btn-primary btn-lg mx-2">Add Service</a>
        <a href="pages/bookings_create.php" class="btn btn-outline-dark btn-lg mx-2">New Booking</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>