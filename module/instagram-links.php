<?php
include 'koneksi.php';

// Ambil semua data link Instagram
$links = $conn->query("SELECT * FROM instagram_links ORDER BY tanggal_upload DESC");
?>

<link rel="stylesheet" href="css/manual.css">

<main class="container">
    <h2>Daftar Link Instagram</h2>
    <p>Berikut adalah daftar akun atau halaman Instagram yang bisa kamu kunjungi untuk informasi atau komunitas terkait:</p>

    <table class="manual-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Link</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $links->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
                    <td>
                        <a href="<?= htmlspecialchars($row['link_instagram']) ?>" target="_blank">Kunjungi</a>
                    </td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal_upload'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
