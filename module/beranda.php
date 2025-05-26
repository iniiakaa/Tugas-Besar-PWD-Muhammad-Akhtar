<link rel="stylesheet" href="module/css2/beranda.css">

 <?php
include 'koneksi.php';

// Ambil semua data banner dari database
$result = $conn->query("SELECT * FROM banner ORDER BY id ASC");

// Misal kamu hanya ingin tampilkan banner pertama atau semua banner
?>

<main>
  <?php while ($row = $result->fetch_assoc()): ?>
    <section>
        <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>" style="width: 100%; height: auto;">
      </a>
    </section>
  <?php endwhile; ?>
</main>
