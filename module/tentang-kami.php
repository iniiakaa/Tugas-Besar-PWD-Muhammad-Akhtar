<?php
include 'koneksi.php'; // koneksi ke database

$tentang = $conn->query("SELECT * FROM tentang_kami LIMIT 1");
$data = $tentang->fetch_assoc();
?>

<section id="tentang-kami" style="text-align: center; max-width: 600px; margin: 0 auto;  margin-top: 8rem; padding: 0 10px; font-family: sans-serif;">
  <h1 style="font-size: 2.5rem; margin-bottom: 1rem;"><?= htmlspecialchars($data['judul']) ?></h1>

  <?php if (!empty($data['logo'])): ?>
    <img src="<?= htmlspecialchars($data['logo']) ?>" alt="Logo" style="width: 150px; margin: 20px 0;">
  <?php endif; ?>

  <p style="text-align: justify;"><?= $data['paragraf1'] ?></p>
  <p style="text-align: justify;"><?= $data['paragraf2'] ?></p>
  <p style="text-align: justify;"><?= $data['paragraf3'] ?></p>
</section>
