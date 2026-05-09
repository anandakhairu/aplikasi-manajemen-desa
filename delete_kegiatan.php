<?php
include 'koneksi.php';

$id_kegiatan = $_GET['id_kegiatan'];

$sql = "DELETE FROM kegiatan WHERE id_kegiatan='$id_kegiatan'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data kegiatan berhasil dihapus');window.location='read_kegiatan.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
