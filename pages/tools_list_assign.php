<?php
include "../db.php";

$message = "";
$messageType = "";

if (isset($_POST['assign'])) {
    $booking_id = (int)$_POST['booking_id'];
    $tool_id    = (int)$_POST['tool_id'];
    $qty        = (int)$_POST['qty_used'];

    // Get current available quantity
    $toolQuery = mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id = $tool_id");
    $tool = mysqli_fetch_assoc($toolQuery);

    $available = $tool ? (int)$tool['quantity_available'] : 0;

    if ($qty > $available) {
        $message = "Not enough available tools! (Only $available left)";
        $messageType = "danger";
    } else {
        // Insert assignment
        $insert = mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used) 
                                       VALUES ($booking_id, $tool_id, $qty)");
        
        // Update available quantity
        $update = mysqli_query($conn, "UPDATE tools 
                                       SET quantity_available = quantity_available - $qty 
                                       WHERE tool_id = $tool_id");

        if ($insert && $update) {
            $message = "Tool assigned successfully!";
            $messageType = "success";
        } else {
            $message = "Error assigning tool. Please try again.";
            $messageType = "danger";
        }
    }
}

// ────────────────────────────────────────────────
// Separate queries so we can use them independently
// ────────────────────────────────────────────────
$tools_for_table = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$tools_for_dropdown = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools / Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="page-container">
    <div class="list-header">
        <h2 class="clients-heading">Tools / Inventory</h2>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?= $messageType ?> mb-4" role="alert">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($tools_for_table) === 0): ?>
        <div class="empty-state mb-5">
            <span class="icon-wrapper"><i class="bi bi-tools"></i></span>
            <h4>No Tools Found</h4>
            <p>No tools have been added to inventory yet.</p>
        </div>
    <?php else: ?>
        <div class="clients-card mb-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tool Name</th>
                            <th>Total Qty</th>
                            <th>Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($t = mysqli_fetch_assoc($tools_for_table)): ?>
                            <tr>
                                <td><?= htmlspecialchars($t['tool_name']) ?></td>
                                <td><?= $t['quantity_total'] ?? '—' ?></td>
                                <td>
                                    <?php if (($t['quantity_available'] ?? 0) > 0): ?>
                                        <span class="badge bg-success"><?= $t['quantity_available'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">0</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <!-- Assign Tool Form -->
    <div class="assign-tool-box">
        <h3>Assign Tool to Booking</h3>

        <?php if (mysqli_num_rows($bookings) === 0): ?>
            <div class="alert alert-warning">
                No bookings exist yet. Please create a booking first.
            </div>
        <?php else: ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Booking ID <span class="required">*</span></label>
                    <select name="booking_id" class="form-select" required>
                        <?php while ($b = mysqli_fetch_assoc($bookings)): ?>
                            <option value="<?= $b['booking_id'] ?>">
                                #<?= $b['booking_id'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tool <span class="required">*</span></label>
                    <select name="tool_id" class="form-select" required>
                        <?php while ($t = mysqli_fetch_assoc($tools_for_dropdown)): ?>
                            <option value="<?= $t['tool_id'] ?>">
                                <?= htmlspecialchars($t['tool_name']) ?> 
                                (Available: <?= $t['quantity_available'] ?? 0 ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Qty Used <span class="required">*</span></label>
                    <input type="number" name="qty_used" class="form-control" min="1" value="1" required>
                </div>

                <div class="form-actions">
                    <button type="submit" name="assign" class="btn btn-primary btn-lg">
                        <i class="bi bi-wrench me-1"></i> Assign Tool
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>