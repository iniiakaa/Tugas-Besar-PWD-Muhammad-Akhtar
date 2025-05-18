<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION['username'] ?? ''; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
  <header>
    <div>📋 Sistem Toko</div>
    <div>Selamat datang, <?= htmlspecialchars($username) ?></div>

  </header>


