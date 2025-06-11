<?php
include 'koneksi.php'; // koneksi ke database
$data = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<link rel="stylesheet" href="module/css2/news.css">

<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<article>
  <img src="uploads/<?= $row['gambar']; ?>" alt="<?= htmlspecialchars($row['judul']); ?>">
  <h2><?= htmlspecialchars($row['judul']); ?></h2>
  <p><?= date("d F Y", strtotime($row['tanggal'])); ?></p>
  <p><?= nl2br(htmlspecialchars($row['isi'])); ?></p>
  
</article>
<?php } ?>
