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
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "nav.php"; ?>

<main>
    <h1>Dashboard</h1>

    <div class="stats-box">
        <div class="stats">
            <p>Total Clients: <b><?php echo $clients; ?></b></p>
            <p>Total Services: <b><?php echo $services; ?></b></p>
            <p>Total Bookings: <b><?php echo $bookings; ?></b></p>
            <p>Total Revenue: <b>₱<?php echo number_format($revenue, 2); ?></b></p>
        </div>
    </div>

    <div class="quick-links-section">
        <h2 class="quick-links-title">Quick Links</h2>
        <div class="quick-links">
            <a href="/assessment_beginner/pages/clients_add.php">Add Client</a>
            <a href="/assessment_beginner/pages/bookings_create.php">Create Booking</a>
        </div>
    </div>
</main>

</body>
</html>