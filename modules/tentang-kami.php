<?php
include 'koneksi.php';


// Ambil data dari database
$tentang = $conn->query("SELECT * FROM tentang_kami LIMIT 1");
$data = $tentang->fetch_assoc();

$edit_id = $data['id'] ?? '';
$edit_judul = $data['judul'] ?? 'Tentang Kami';
$edit_logo = $data['logo'] ?? '';
$edit_paragraf1 = $data['paragraf1'] ?? '';
$edit_paragraf2 = $data['paragraf2'] ?? '';
$edit_paragraf3 = $data['paragraf3'] ?? '';

// Pesan status
$status_msg = '';
$status_class = '';

// Proses update
if (isset($_POST['update'])) {
    // Bersihkan input
    $judul = htmlspecialchars(trim($_POST['judul']));
    $p1 = htmlspecialchars(trim($_POST['paragraf1']));
    $p2 = htmlspecialchars(trim($_POST['paragraf2']));
    $p3 = htmlspecialchars(trim($_POST['paragraf3']));
    
    $logo = $edit_logo;
    $old_logo = $edit_logo;
    
    // Proses upload logo baru
    if (!empty($_FILES['logo']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_name = $_FILES['logo']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed)) {
            // Hapus logo lama jika ada
            if (!empty($old_logo) && file_exists("uploads/$old_logo")) {
                unlink("uploads/$old_logo");
            }
            
            // Buat nama unik untuk file baru
            $new_filename = 'logo_' . uniqid() . '.' . $file_ext;
            $tmp = $_FILES['logo']['tmp_name'];
            
            // Pastikan folder uploads ada
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }
            
            if (move_uploaded_file($tmp, "uploads/" . $new_filename)) {
                $logo = $new_filename;
            } else {
                $status_msg = "Gagal mengupload logo. Gunakan logo sebelumnya.";
                $status_class = 'error';
            }
        } else {
            $status_msg = "Format file tidak didukung. Gunakan JPG, PNG, atau GIF.";
            $status_class = 'error';
        }
    }
    
    // Update data di database
    if ($edit_id) {
        $stmt = $conn->prepare("UPDATE tentang_kami SET 
            judul = ?,
            logo = ?,
            paragraf1 = ?,
            paragraf2 = ?,
            paragraf3 = ?
            WHERE id = ?");
        $stmt->bind_param("sssssi", $judul, $logo, $p1, $p2, $p3, $edit_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO tentang_kami (judul, logo, paragraf1, paragraf2, paragraf3) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $judul, $logo, $p1, $p2, $p3);
    }
    
    if ($stmt->execute()) {
        $status_msg = "Data berhasil diperbarui!";
        $status_class = 'success';
        
        // Perbarui data tampilan
        $edit_judul = $judul;
        $edit_logo = $logo;
        $edit_paragraf1 = $p1;
        $edit_paragraf2 = $p2;
        $edit_paragraf3 = $p3;
    } else {
        $status_msg = "Error: " . $conn->error;
        $status_class = 'error';
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #343a40;
            line-height: 1.6;
            
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .box {
            background: white;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        h1, h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        .preview-logo {
            max-width: 250px;
            height: auto;
            display: block;
            margin: 0 auto 25px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input[type="text"]:focus,
        textarea:focus,
        input[type="file"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        button {
            padding: 12px 25px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        button:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .preview-content {
            line-height: 1.8;
            color: #495057;
        }
        
        .preview-content p {
            margin-bottom: 20px;
        }
        
        .status-message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .logo-preview {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .current-logo {
            max-width: 120px;
            border-radius: 6px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .box {
                padding: 20px;
            }
            
            .logo-preview {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Manajemen Halaman "Tentang Kami"</h1>
    
    <?php if ($status_msg): ?>
        <div class="status-message <?= $status_class ?>">
            <?= $status_msg ?>
        </div>
    <?php endif; ?>

    <!-- PREVIEW -->
    <div class="box">
        <h2>Preview</h2>
        
        <?php if ($edit_logo): ?>
            <img src="uploads/<?= htmlspecialchars($edit_logo) ?>" 
                 alt="Logo" class="preview-logo">
        <?php endif; ?>
        
        <h2 style="text-align: center;"><?= htmlspecialchars($edit_judul) ?></h2>
        
        <div class="preview-content">
            <?php if ($edit_paragraf1): ?>
                <p><?= nl2br(htmlspecialchars($edit_paragraf1)) ?></p>
            <?php endif; ?>
            
            <?php if ($edit_paragraf2): ?>
                <p><?= nl2br(htmlspecialchars($edit_paragraf2)) ?></p>
            <?php endif; ?>
            
            <?php if ($edit_paragraf3): ?>
                <p><?= nl2br(htmlspecialchars($edit_paragraf3)) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- FORM EDIT -->
    <div class="box">
        <h2>Edit Konten</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $edit_id ?>">
            
            <div class="form-group">
                <label for="judul">Judul Halaman</label>
                <input type="text" name="judul" id="judul" 
                       value="<?= htmlspecialchars($edit_judul) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="logo">Logo Perusahaan</label>
                
                <?php if ($edit_logo): ?>
                    <div class="logo-preview">
                        <img src="uploads/<?= htmlspecialchars($edit_logo) ?>" 
                             alt="Logo saat ini" class="current-logo">
                        <div>
                            <p>Logo saat ini</p>
                            <small>Unggah file baru untuk mengganti logo</small>
                        </div>
                    </div>
                <?php endif; ?>
                
                <input type="file" name="logo" id="logo" accept="image/*">
                <small style="display: block; margin-top: 8px; color: #6c757d;">
                    Format: JPG, PNG, GIF, WEBP. Maks. 2MB.
                </small>
            </div>
            
            <div class="form-group">
                <label for="paragraf1">Paragraf 1</label>
                <textarea name="paragraf1" id="paragraf1" rows="5"><?= htmlspecialchars($edit_paragraf1) ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="paragraf2">Paragraf 2 (Opsional)</label>
                <textarea name="paragraf2" id="paragraf2" rows="5"><?= htmlspecialchars($edit_paragraf2) ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="paragraf3">Paragraf 3 (Opsional)</label>
                <textarea name="paragraf3" id="paragraf3" rows="5"><?= htmlspecialchars($edit_paragraf3) ?></textarea>
            </div>
            
            <button type="submit" name="update">Simpan Perubahan</button>
        </form>
    </div>
</div>
</body>
</html>