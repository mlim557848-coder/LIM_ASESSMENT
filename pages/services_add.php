<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
    $service_name  = trim($_POST['service_name'] ?? '');
    $description   = trim($_POST['description'] ?? '');
    $hourly_rate   = trim($_POST['hourly_rate'] ?? '');
    $is_active     = (int)($_POST['is_active'] ?? 0);

    if ($service_name === '' || $hourly_rate === '') {
        $message = "Service name and hourly rate are required!";
    } elseif (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
        $message = "Hourly rate must be a number greater than 0.";
    } else {
        $stmt = mysqli_prepare($conn, 
            "INSERT INTO services (service_name, description, hourly_rate, is_active) 
             VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssdi", $service_name, $description, $hourly_rate, $is_active);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: services_list.php?success=1");
            exit;
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="form-container">
    <h2 class="clients-heading text-center">Add New Service</h2>

    <?php if ($message): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Service Name <span class="required">*</span></label>
            <input type="text" name="service_name" class="form-control" required 
                   value="<?= htmlspecialchars($_POST['service_name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Hourly Rate (₱) <span class="required">*</span></label>
            <input type="number" name="hourly_rate" class="form-control" step="0.01" min="0" required
                   value="<?= htmlspecialchars($_POST['hourly_rate'] ?? '') ?>">
        </div>

        <div class="mb-4">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" name="save" class="btn btn-primary btn-lg">Save Service</button>
            <a href="services_list.php" class="btn btn-outline-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>