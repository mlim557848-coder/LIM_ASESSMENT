<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC")
    or die(mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="page-container">

    <div class="list-header">
        <h2 class="clients-heading">Services</h2>
        <a href="services_add.php" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2">
            <i class="bi bi-plus-lg"></i> Add New Service
        </a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>

        <div class="card clients-card shadow border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 clients-table">
                        <thead>
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Service Name</th>
                                <th>Hourly Rate</th>
                                <th>Active</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4 fw-medium"><?= htmlspecialchars($row['service_id']) ?></td>
                                <td><?= htmlspecialchars($row['service_name']) ?></td>
                                <td>₱<?= number_format($row['hourly_rate'], 2) ?></td>
                                <td>
                                    <?php if ($row['is_active']): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4 action-cell">
                                    <a href="services_edit.php?id=<?= $row['service_id'] ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="empty-state">
            <div class="icon-wrapper">
                <i class="bi bi-scissors"></i>
            </div>
            <h4>No services yet</h4>
            <p>Start by adding your first service.</p>
            <a href="services_add.php" class="btn btn-primary btn-lg px-5 mt-3">
                <i class="bi bi-plus-lg me-1"></i> Add Service
            </a>
        </div>

    <?php endif; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>