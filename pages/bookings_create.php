<?php
include "../db.php";
 
$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");
 
if (isset($_POST['create'])) {
  $client_id = $_POST['client_id'];
  $service_id = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours = $_POST['hours'];
 
  // get service hourly rate
  $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
 
  $total = $rate * $hours;
 
  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");
 
  header("Location: bookings_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="page-container">
    <div class="form-container">
        <h2 class="clients-heading">Create Booking</h2>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Client <span class="required">*</span></label>
                <select name="client_id" class="form-select" required>
                    <?php while($c = mysqli_fetch_assoc($clients)) { ?>
                        <option value="<?php echo $c['client_id']; ?>"><?php echo htmlspecialchars($c['full_name']); ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Service <span class="required">*</span></label>
                <select name="service_id" class="form-select" required>
                    <?php while($s = mysqli_fetch_assoc($services)) { ?>
                        <option value="<?php echo $s['service_id']; ?>">
                            <?php echo htmlspecialchars($s['service_name']); ?> (₱<?php echo number_format($s['hourly_rate'],2); ?>/hr)
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Date <span class="required">*</span></label>
                <input type="date" name="booking_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hours <span class="required">*</span></label>
                <input type="number" name="hours" class="form-control" min="1" value="1" required>
            </div>

            <div class="form-actions">
                <a href="bookings_list.php" class="btn btn-outline-secondary btn-lg">Cancel</a>
                <button type="submit" name="create" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-1"></i> Create Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>