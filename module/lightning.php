<?php
include 'koneksi.php';

// Hanya ambil produk dengan kategori 'lightning'
$kategori = 'lightning';
$safe_kategori = $conn->real_escape_string($kategori);

// Ambil sort dari URL, default 'asc'
$sort = $_GET['sort'] ?? 'asc';
$sort = ($sort === 'desc') ? 'DESC' : 'ASC';

// Query hanya produk kategori lightning
$sql = "SELECT * FROM barang WHERE kategori = '$safe_kategori' ORDER BY id $sort";
$result = $conn->query($sql);
$total_produk = $result->num_rows;
?>

<link rel="stylesheet" href="module/css2/allproduct.css">

<main>
    <div>
        <form method="GET">
            <label>Urutkan:</label>
            <select name="sort" onchange="this.form.submit()">
                <option value="desc" <?= $sort === 'DESC' ? 'selected' : '' ?>>Terbaru</option>
                <option value="asc" <?= $sort === 'ASC' ? 'selected' : '' ?>>Terlama</option>
            </select>
        </form>

        <span><?= $total_produk ?> produk ditemukan</span>
    </div>

    <!-- Daftar Produk -->
    <section>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <div>
                    <?php if (!empty($row['foto']) && file_exists('uploads/' . $row['foto'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>">
                    <?php else: ?>
                        <img src="element/item-1.jpg" alt="No Image">
                    <?php endif; ?>
                </div>
                <p><?= htmlspecialchars($row['nama']) ?></p>
                <p>Rp <?= number_format($row['harga'], 0, ',', '.') ?>,00</p>
            </div>
        <?php endwhile; ?>
    </section>
</main>
