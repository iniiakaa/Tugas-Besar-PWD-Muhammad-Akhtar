<?php
include 'koneksi.php';

// Ambil semua data WhatsApp
$links = $conn->query("SELECT * FROM whatsapp_links ORDER BY tanggal_upload DESC");
?>

<link rel="stylesheet" href="css/manual.css">

<main class="container">
    <h2>Daftar Link WhatsApp</h2>
    <p>Berikut adalah daftar link grup atau kontak WhatsApp yang dapat kamu kunjungi untuk bergabung atau mendapatkan informasi:</p>

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
                        <a href="<?= htmlspecialchars($row['link_whatsapp']) ?>" target="_blank">Gabung</a>
                    </td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal_upload'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
