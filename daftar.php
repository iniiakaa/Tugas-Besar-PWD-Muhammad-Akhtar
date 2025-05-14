<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Akun</title>
  <link rel="stylesheet" href="css/daftar.css">
  <script>
    // Tampilkan pop-up error jika ada
    window.onload = function() {
        <?php if (isset($_SESSION['error'])): ?>
            alert("<?= htmlspecialchars($_SESSION['error'], ENT_QUOTES) ?>");
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    };
  </script>
</head>
<body>
  <main>
    <section>
      <h1>Noir Gear</h1>
      <form action="register.php" method="POST">
        <h2>Daftar Akun</h2>
        <p>Silakan isi formulir untuk membuat akun baru</p>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
        <button type="submit">Daftar</button>
      </form>
      <a href="masuk.php">Kembali ke Login</a>
    </section>
  </main>
</body>
</html>