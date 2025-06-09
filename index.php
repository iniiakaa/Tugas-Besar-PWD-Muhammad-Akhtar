
<?php
session_start();

include 'koneksi.php';
include 'include/header.php';

echo '<main>';

$modul = isset($_GET['modul']) ? $_GET['modul'] : 'allproduct';
$file = "module/$modul.php";

if ($modul === 'allroduct') {
    include 'module/allproduct.php';

}

if (file_exists($file)) {
    include $file;
} else {
    echo "<h2>Modul tidak ditemukan</h2>";
}

echo '</main>';




include 'include/footer.php';
?>

