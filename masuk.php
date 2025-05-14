<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/masuk.css">
  <script>
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
      <form action="login.php" method="POST">
        <h2>Login</h2>
        <p>Masukkan username dan password Anda untuk login</p>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Lanjutkan</button>
      </form>
      <a href="daftar.php">Daftar Akun</a>
    </section>
  </main>
</body>
</html>