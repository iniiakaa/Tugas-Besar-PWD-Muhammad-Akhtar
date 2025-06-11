<link rel="stylesheet" href="css/manual.css">
<link rel="stylesheet" href="css/iya.css">
<?php
include 'koneksi.php';

$edit_mode = false;
$edit_id = "";
$edit_judul = "";
$edit_deskripsi = "";
$edit_link = "";

// Proses Tambah
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $link_discord = $_POST['link_discord'];
    $tanggal_upload = date("Y-m-d H:i:s");

    $conn->query("INSERT INTO discord_links (judul, deskripsi, link_discord, tanggal_upload) VALUES 
        ('$judul', '$deskripsi', '$link_discord', '$tanggal_upload')");

    header("Location: dashboard.php?modul=discord-links");
    exit;
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM discord_links WHERE id = $id");
    header("Location: dashboard.php?modul=discord-links");
    exit;
}

// Proses Edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM discord_links WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_mode = true;
        $edit_judul = $row['judul'];
        $edit_deskripsi = $row['deskripsi'];
        $edit_link = $row['link_discord'];
    }
}

// Proses Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $link_discord = $_POST['link_discord'];

    $conn->query("UPDATE discord_links SET judul='$judul', deskripsi='$deskripsi', link_discord='$link_discord' WHERE id=$id");

    header("Location: dashboard.php?modul=discord-links");
    exit;
}

// Ambil semua data
$links = $conn->query("SELECT * FROM discord_links ORDER BY tanggal_upload DESC");
?>

<h1>Manajemen Link Discord</h1>

<?php if ($edit_mode): ?>
    <h3>Edit Link</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_id ?>">
        <input type="text" name="judul" value="<?= htmlspecialchars($edit_judul) ?>" required>
        <textarea name="deskripsi" required><?= htmlspecialchars($edit_deskripsi) ?></textarea>
        <input type="url" name="link_discord" value="<?= htmlspecialchars($edit_link) ?>" required placeholder="https://discord.gg/...">
        <button type="submit" name="update">Update</button>
        <a href="dashboard.php?modul=discord-links">Batal</a>
    </form>
<?php else: ?>
    <h3>Tambah Link Discord</h3>
    <form method="POST">
        <input type="text" name="judul" placeholder="Judul" required>
        <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
        <input type="url" name="link_discord" placeholder="https://discord.gg/..." required>
        <button type="submit" name="tambah">Tambah</button>
    </form>
<?php endif; ?>

<h3>Daftar Link Discord</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Link</th>
        <th>Tanggal Upload</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $links->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td><a href="<?= htmlspecialchars($row['link_discord']) ?>" target="_blank">Kunjungi</a></td>
            <td><?= $row['tanggal_upload'] ?></td>
            <td>
                <a href="dashboard.php?modul=discord-links&edit=<?= $row['id'] ?>">Edit</a> |
                <a href="dashboard.php?modul=discord-links&hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
