<?php
include "../db.php";

$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $address   = trim($_POST['address'] ?? '');

    if ($full_name === '' || $email === '') {
        $message = "Full Name and Email are required.";
        $success = false;
    } else {
        $stmt = mysqli_prepare($conn, 
            "INSERT INTO clients (full_name, email, phone, address) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $phone, $address);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = true;
            $message = "Client added successfully!";
        } else {
            $message = "Database error: " . mysqli_error($conn);
            $success = false;
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
    <title>Add Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="form-container">

    <h2 class="clients-heading text-center">Add New Client</h2>

    <?php if ($message): ?>
        <div class="alert alert-<?= $success ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="text-center mt-4">
            <a href="clients_list.php" class="btn btn-outline-secondary px-4 me-3">Back to List</a>
            <a href="clients_add.php" class="btn btn-primary px-4">Add Another</a>
        </div>
    <?php else: ?>

    <form method="post" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Full Name <span class="required">*</span></label>
            <input type="text" name="full_name" class="form-control" required 
                   value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control" required 
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" name="phone" class="form-control" 
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
        </div>

        <div class="mb-4">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" 
                   value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
        </div>

        <div class="form-actions">
            <button type="submit" name="save" class="btn btn-primary btn-lg">Save Client</button>
            <a href="clients_list.php" class="btn btn-outline-secondary btn-lg">Cancel</a>
        </div>
    </form>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>