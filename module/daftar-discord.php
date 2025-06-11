<link rel="stylesheet" href="css/manual.css">
<?php
include 'koneksi.php';

// Ambil semua data link Discord
$links = $conn->query("SELECT * FROM discord_links ORDER BY tanggal_upload DESC");
?>

<div class="container">
    <h1>Daftar Link Discord</h1>
    <p>Berikut adalah daftar link Discord yang tersedia. Klik untuk bergabung atau melihat komunitas terkait:</p>

    <?php if ($links->num_rows > 0): ?>
        <table>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Link</th>
                <th>Tanggal Upload</th>
            </tr>
            <?php while ($row = $links->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td><a href="<?= htmlspecialchars($row['link_discord']) ?>" target="_blank">Buka Discord</a></td>
                    <td><?= $row['tanggal_upload'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Tidak ada link Discord yang tersedia saat ini.</p>
    <?php endif; ?>
</div>
