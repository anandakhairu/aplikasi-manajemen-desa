<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Ambil ID dari URL dengan aman
$id_partisipasi = isset($_GET['id_partisipasi']) ? intval($_GET['id_partisipasi']) : 0;

// Validasi ID
if ($id_partisipasi <= 0) {
    echo "<script>alert('ID tidak valid!');window.location='read_partisipasi.php';</script>";
    exit;
}

// Hapus data partisipasi
$sql = "DELETE FROM partisipasi WHERE id_partisipasi='$id_partisipasi'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data partisipasi berhasil dihapus');window.location='read_partisipasi.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan: ".mysqli_error($conn)."');window.location='read_partisipasi.php';</script>";
}
?>

