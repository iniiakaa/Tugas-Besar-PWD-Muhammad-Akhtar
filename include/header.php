<?php
include 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION['username'] ?? ''; 

// Ambil data produk dari tabel barang
$result = $conn->query("SELECT * FROM barang ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Creature Store</title>
    <link rel="stylesheet" href="include/css3/header.css" />
</head>
<body>

    <!-- Header -->
    <header>
        <div><img src="element/logo.png" alt=""></div>
        <nav>
            
            <ul>
                <li><a href="index.php?modul=beranda">Home</a></li>
                <li><a href="index.php?modul=allproduct">Sale</a></li>
                <li><a href="index.php?modul=lightning">Lightning</a></li>
                <li><a href="index.php?modul=aboutus">About Us</a></li>
                <li><a href="index.php?modul=news">News</a></li>
            </ul>
        </nav>
        <div>
    <span>
    <?php if ($username): ?>
        <a href="logout.php" aria-label="User" title="Profil: <?php echo htmlspecialchars($username); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg> <?php echo htmlspecialchars($username); ?>
        </a>
        </div>
    <?php else: ?>
        <a href="masuk.php" aria-label="Login" title="Masuk">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </a>
    <?php endif; ?>
    </span>
</div>

    </header>