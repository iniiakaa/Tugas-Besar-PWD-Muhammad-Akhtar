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
    $link_instagram = $_POST['link_instagram'];
    $tanggal_upload = date("Y-m-d H:i:s");

    $conn->query("INSERT INTO instagram_links (judul, deskripsi, link_instagram, tanggal_upload) VALUES 
        ('$judul', '$deskripsi', '$link_instagram', '$tanggal_upload')");

    header("Location: dashboard.php?modul=instagram-links");
    exit;
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM instagram_links WHERE id = $id");
    header("Location: dashboard.php?modul=instagram-links");
    exit;
}

// Proses Edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM instagram_links WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_mode = true;
        $edit_judul = $row['judul'];
        $edit_deskripsi = $row['deskripsi'];
        $edit_link = $row['link_instagram'];
    }
}

// Proses Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $link_instagram = $_POST['link_instagram'];

    $conn->query("UPDATE instagram_links SET judul='$judul', deskripsi='$deskripsi', link_instagram='$link_instagram' WHERE id=$id");

    header("Location: dashboard.php?modul=instagram-links");
    exit;
}

// Ambil semua data
$links = $conn->query("SELECT * FROM instagram_links ORDER BY tanggal_upload DESC");
?>

<h1>Manajemen Link Instagram</h1>

<?php if ($edit_mode): ?>
    <h3>Edit Link</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_id ?>">
        <input type="text" name="judul" value="<?= htmlspecialchars($edit_judul) ?>" required>
        <textarea name="deskripsi" required><?= htmlspecialchars($edit_deskripsi) ?></textarea>
        <input type="url" name="link_instagram" value="<?= htmlspecialchars($edit_link) ?>" required placeholder="https://www.instagram.com/...">
        <button type="submit" name="update">Update</button>
        <a href="dashboard.php?modul=instagram-links">Batal</a>
    </form>
<?php else: ?>
    <h3>Tambah Link Instagram</h3>
    <form method="POST">
        <input type="text" name="judul" placeholder="Judul" required>
        <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
        <input type="url" name="link_instagram" placeholder="https://www.instagram.com/..." required>
        <button type="submit" name="tambah">Tambah</button>
    </form>
<?php endif; ?>

<h3>Daftar Link Instagram</h3>
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
            <td><a href="<?= htmlspecialchars($row['link_instagram']) ?>" target="_blank">Kunjungi</a></td>
            <td><?= $row['tanggal_upload'] ?></td>
            <td>
                <a href="dashboard.php?modul=instagram-links&edit=<?= $row['id'] ?>">Edit</a> |
                <a href="dashboard.php?modul=instagram-links&hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
