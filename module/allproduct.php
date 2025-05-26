<?php
include 'koneksi.php';

// ngambil daftar kategori unik
$kategori_query = $conn->query("SELECT DISTINCT kategori FROM barang ORDER BY kategori ASC");
$kategori_list = [];
while ($row = $kategori_query->fetch_assoc()) {
    $kategori_list[] = $row['kategori'];
}

// ngambil filter dari URL
$kategori_filter = $_GET['kategori'] ?? '';
$sort = $_GET['sort'] ?? 'desc';

//  query SQL
$sql = "SELECT * FROM barang";
$conditions = [];

if (!empty($kategori_filter)) {
    $safe_kategori = $conn->real_escape_string($kategori_filter);
    $conditions[] = "kategori = '$safe_kategori'";
}

if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY id " . ($sort === 'asc' ? 'ASC' : 'DESC');

$result = $conn->query($sql);
$total_produk = $result->num_rows;
?>


<link rel="stylesheet" href="module/css2/allproduct.css">

<main>
    <div>
        <form method="GET" >
            <label>Filter: </label>
            <select name="kategori" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori_list as $kategori): ?>
                    <option value="<?= htmlspecialchars($kategori) ?>" <?= $kategori === $kategori_filter ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kategori) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Urutkan:</label>
            <select name="sort" onchange="this.form.submit()">
                <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Terbaru</option>
                <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Terlama</option>
            </select>
        </form>

        <span ><?= $total_produk ?> produk</span>
    </div>

    <!-- Produk -->
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
