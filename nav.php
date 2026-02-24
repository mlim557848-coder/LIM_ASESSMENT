<?php // nav.php ?>
<!-- Bootstrap CSS — loaded here so nav works from any folder (root or /pages/) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 mb-4">
  <a class="navbar-brand fw-bold" href="/assessment_beginner/index.php">
    <i class="bi bi-scissors me-2"></i>SalonApp
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navMenu">
    <ul class="navbar-nav ms-auto gap-1">
      <li class="nav-item">
        <a class="nav-link" href="/assessment_beginner/index.php">
          <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/assessment_beginner/pages/clients_list.php">
          <i class="bi bi-people me-1"></i>Clients
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/assessment_beginner/pages/services_list.php">
          <i class="bi bi-scissors me-1"></i>Services
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/assessment_beginner/pages/bookings_list.php">
          <i class="bi bi-calendar-check me-1"></i>Bookings
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/assessment_beginner/pages/tools_list_assign.php">
          <i class="bi bi-tools me-1"></i>Tools
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/assessment_beginner/pages/payments_list.php">
          <i class="bi bi-credit-card me-1"></i>Payments
        </a>
      </li>
    </ul>
  </div>
</nav>

<!-- Bootstrap JS bundle (needed for mobile hamburger toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>