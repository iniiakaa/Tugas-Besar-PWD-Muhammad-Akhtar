<?php
include 'koneksi.php';

// Ambil semua manual book tanpa dipisah kategori
$manuals = $conn->query("SELECT * FROM manual_book ORDER BY tanggal_upload DESC");
?>

<link rel="stylesheet" href="css/manual.css">

<div class="container">
    <h2>Manual Book</h2>
    <p>Berikut adalah daftar manual book yang telah tersedia dan dapat diakses langsung:</p>

    <table class="manual-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>File</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $manuals->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
                <td>
                    <?php if ($row['file_manual']): ?>
                        <a href="uploads/manual/<?= htmlspecialchars($row['file_manual']) ?>" target="_blank">Lihat</a>
                    <?php else: ?>
                        Tidak ada file
                    <?php endif; ?>
                </td>
                <td><?= date('d-m-Y', strtotime($row['tanggal_upload'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
