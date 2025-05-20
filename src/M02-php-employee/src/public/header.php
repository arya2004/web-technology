<?php
// src/public/header.php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="employees.php">Employee Manager</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
<?php if (!empty($_SESSION['user_id'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="add_employee.php">Add Employee</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
<?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
