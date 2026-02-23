<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC")
    or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="page-container">

    <div class="list-header">
        <h2 class="clients-heading">Clients</h2>
        <a href="clients_add.php" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2">
            <i class="bi bi-plus-lg"></i> Add New Client
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4 fw-medium"><?= htmlspecialchars($row['client_id']) ?></td>
                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone'] ?: '—') ?></td>
                                <td class="text-end pe-4 action-cell">
                                    <a href="clients_edit.php?id=<?= $row['client_id'] ?>" 
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
                <i class="bi bi-people"></i>
            </div>
            <h4>No clients yet</h4>
            <p>Start by adding your first client.</p>
            <a href="clients_add.php" class="btn btn-primary btn-lg px-5 mt-3">
                <i class="bi bi-plus-lg me-1"></i> Add Client
            </a>
        </div>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>