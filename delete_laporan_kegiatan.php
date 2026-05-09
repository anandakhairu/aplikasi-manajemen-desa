<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Pastikan id_laporan ada di URL
if (!isset($_GET['id_laporan'])) {
    echo "<script>alert('ID laporan tidak ditemukan');window.location='read_laporan_kegiatan.php';</script>";
    exit;
}

// Ambil id_laporan dengan aman
$id_laporan = intval($_GET['id_laporan']);

// Query hapus data
$sql = "DELETE FROM laporan_kegiatan WHERE id_laporan='$id_laporan'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data laporan berhasil dihapus');window.location='read_laporan_kegiatan.php';</script>";
} else {
    echo "<script>alert('Hapus gagal: " . mysqli_error($conn) . "');window.location='read_laporan_kegiatan.php';</script>";
}
?>

