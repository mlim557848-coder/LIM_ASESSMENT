<?php
include "db.php";

// Fetch counts safely (with fallback to 0)
$clientsQuery = mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients");
$clients = $clientsQuery ? mysqli_fetch_assoc($clientsQuery)['c'] ?? 0 : 0;

$servicesQuery = mysqli_query($conn, "SELECT COUNT(*) AS c FROM services");
$services = $servicesQuery ? mysqli_fetch_assoc($servicesQuery)['c'] ?? 0 : 0;

$bookingsQuery = mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings");
$bookings = $bookingsQuery ? mysqli_fetch_assoc($bookingsQuery)['c'] ?? 0 : 0;

$revenueQuery = mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid), 0) AS s FROM payments");
$revenueRow = $revenueQuery ? mysqli_fetch_assoc($revenueQuery) : null;
$revenue = $revenueRow['s'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- keep your custom styles if needed -->
</head>
<body class="bg-light">

<?php include "nav.php"; ?>

<main class="container my-5">
    <h1 class="text-center mb-5 fw-bold">Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="row g-4 justify-content-center">
        
        <!-- Total Clients -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-primary h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill text-primary display-4 mb-3"></i>
                    <h5 class="card-title text-muted">Total Clients</h5>
                    <h2 class="fw-bold"><?php echo $clients; ?></h2>
                </div>
            </div>
        </div>

        <!-- Total Services -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-success h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-scissors text-success display-4 mb-3"></i>
                    <h5 class="card-title text-muted">Total Services</h5>
                    <h2 class="fw-bold"><?php echo $services; ?></h2>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-warning h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-calendar-check text-warning display-4 mb-3"></i>
                    <h5 class="card-title text-muted">Total Bookings</h5>
                    <h2 class="fw-bold"><?php echo $bookings; ?></h2>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-danger h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-currency-dollar text-danger display-4 mb-3"></i>
                    <h5 class="card-title text-muted">Total Revenue</h5>
                    <h2 class="fw-bold">₱<?php echo number_format($revenue, 2); ?></h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Links -->
    <div class="quick-links-section mt-5 pt-4">
        <h2 class="text-center mb-4 fw-semibold">Quick Links</h2>
        
        <div class="d-flex justify-content-center gap-4 flex-wrap">
            <a href="/assessment_beginner/pages/clients_add.php" 
               class="btn btn-outline-dark btn-lg px-5 py-3 fw-medium">
                <i class="bi bi-person-plus me-2"></i> Add Client
            </a>
            
            <a href="/assessment_beginner/pages/bookings_create.php" 
               class="btn btn-outline-primary btn-lg px-5 py-3 fw-medium">
                <i class="bi bi-plus-circle me-2"></i> Create Booking
            </a>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>