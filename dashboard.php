<link rel="stylesheet" href="css/dashboard.css">
<?php

session_start();

include 'koneksi.php';
include 'includes/header.php';


echo '<main>';

$modul = isset($_GET['modul']) ? $_GET['modul'] : 'home';
$file = "modules/$modul.php";

if (file_exists($file)) {
    include $file;
} else {
    echo "<h2>Modul tidak ditemukan</h2>";
}

echo '</main>';

include 'includes/footer.php';
?>
