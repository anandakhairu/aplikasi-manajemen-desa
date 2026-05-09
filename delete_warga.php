<?php
session_start(); // wajib di awal file
include 'koneksi.php';

$id_warga = $_GET['id_warga'];

$sql = "DELETE FROM warga WHERE id_warga='$id_warga'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data warga berhasil dihapus');window.location='read_warga.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
