<?php
include "../db.php";

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

$client = null;
$message = "";
$success = false;

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM clients WHERE client_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $client = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$client) {
    $message = "Client not found.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update']) && $client) {
    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $address   = trim($_POST['address'] ?? '');

    if ($full_name === '' || $email === '') {
        $message = "Full Name and Email are required.";
    } else {
        $stmt = mysqli_prepare($conn, 
            "UPDATE clients SET full_name = ?, email = ?, phone = ?, address = ? WHERE client_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $full_name, $email, $phone, $address, $id);
        $success = mysqli_stmt_execute($stmt);
        $message = $success ? "Client updated successfully!" : "Error: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        
        if ($success) {
            $client['full_name'] = $full_name;
            $client['email']     = $email;
            $client['phone']     = $phone;
            $client['address']   = $address;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="form-container">

    <h2 class="clients-heading">Edit Client</h2>

    <?php if ($message): ?>
        <div class="alert alert-<?= $success ? 'success' : 'danger' ?> alert-dismissible fade show mb-4" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($client): ?>

        <form method="post">
            <div class="mb-4">
                <label class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($client['full_name']) ?>">
            </div>

            <div class="mb-4">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($client['email']) ?>">
            </div>

            <div class="mb-4">
                <label class="form-label">Phone</label>
                <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($client['phone'] ?? '') ?>">
            </div>

            <div class="mb-5">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($client['address'] ?? '') ?>">
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn btn-primary btn-lg">Update Client</button>
                <a href="clients_list.php" class="btn btn-outline-secondary btn-lg">Cancel</a>
            </div>
        </form>

    <?php else: ?>
        <div class="text-center py-5">
            <p class="lead text-muted mb-4">Client not found.</p>
            <a href="clients_list.php" class="btn btn-outline-primary btn-lg px-5">Back to List</a>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>