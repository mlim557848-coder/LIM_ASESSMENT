<?php
include "../db.php";

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

$service = null;
$message = "";
$success = false;

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM services WHERE service_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $service = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$service) {
    $message = "Service not found.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update']) && $service) {
    $name   = trim($_POST['service_name'] ?? '');
    $desc   = trim($_POST['description'] ?? '');
    $rate   = trim($_POST['hourly_rate'] ?? '');
    $active = (int)($_POST['is_active'] ?? 0);

    if ($name === '' || $rate === '') {
        $message = "Service Name and Hourly Rate are required.";
    } else {
        $stmt = mysqli_prepare($conn,
            "UPDATE services SET service_name=?, description=?, hourly_rate=?, is_active=? WHERE service_id=?");
        mysqli_stmt_bind_param($stmt, "ssdii", $name, $desc, $rate, $active, $id);
        $success = mysqli_stmt_execute($stmt);
        $message = $success ? "Service updated successfully!" : "Error: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);

        if ($success) {
            $service['service_name'] = $name;
            $service['description']  = $desc;
            $service['hourly_rate']  = $rate;
            $service['is_active']    = $active;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="form-container">

    <h2 class="clients-heading">Edit Service</h2>

    <?php if ($message): ?>
        <div class="alert alert-<?= $success ? 'success' : 'danger' ?> alert-dismissible fade show mb-4" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($service): ?>

        <form method="post">
            <div class="mb-4">
                <label class="form-label">Service Name <span class="required">*</span></label>
                <input type="text" name="service_name" class="form-control" required
                       value="<?= htmlspecialchars($service['service_name']) ?>">
            </div>

            <div class="mb-4">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"
                          style="height:auto;"><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Hourly Rate <span class="required">*</span></label>
                <input type="number" name="hourly_rate" class="form-control" step="0.01" min="0" required
                       value="<?= htmlspecialchars($service['hourly_rate']) ?>">
            </div>

            <div class="mb-5">
                <label class="form-label">Active</label>
                <select name="is_active" class="form-control">
                    <option value="1" <?= $service['is_active'] == 1 ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= $service['is_active'] == 0 ? 'selected' : '' ?>>No</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn btn-primary btn-lg">Update Service</button>
                <a href="services_list.php" class="btn btn-outline-secondary btn-lg">Cancel</a>
            </div>
        </form>

    <?php else: ?>
        <div class="text-center py-5">
            <p class="lead text-muted mb-4">Service not found.</p>
            <a href="services_list.php" class="btn btn-outline-primary btn-lg px-5">Back to List</a>
        </div>
    <?php endif; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>