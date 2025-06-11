<?php
include 'koneksi.php';
$tentang = $conn->query("SELECT * FROM tentang_kami LIMIT 1");
$data = $tentang->fetch_assoc();
?>

<section id="tentang-kami" style="text-align: center; max-width: 600px; margin: 0 auto; margin-top: 8rem; padding: 0 10px; font-family: sans-serif;">
  <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">
    <?= htmlspecialchars($data['judul']) ?>
  </h1>

  <?php if (!empty($data['logo']) && file_exists('uploads/' . $data['logo'])): ?>
    <img src="uploads/<?= htmlspecialchars($data['logo']) ?>" alt="Logo" style="width: 150px; margin: 20px 0;">
  <?php else: ?>
    <p><em>Logo tidak ditemukan</em></p>
  <?php endif; ?>

  <p style="text-align: justify;">
    <?= nl2br(htmlspecialchars($data['paragraf1'])) ?>
  </p>
  <p style="text-align: justify;">
    <?= nl2br(htmlspecialchars($data['paragraf2'])) ?>
  </p>
  <p style="text-align: justify;">
    <?= nl2br(htmlspecialchars($data['paragraf3'])) ?>
  </p>
</section>
