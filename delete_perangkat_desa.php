<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Ambil ID dari URL dengan aman
$id_perangkat = isset($_GET['id_perangkat']) ? intval($_GET['id_perangkat']) : 0;

// Validasi ID
if ($id_perangkat <= 0) {
    echo "<script>alert('ID tidak valid!');window.location='read_perangkat_desa.php';</script>";
    exit;
}

// Hapus data perangkat desa
$sql = "DELETE FROM perangkat_desa WHERE id_perangkat='$id_perangkat'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data perangkat desa berhasil dihapus');window.location='read_perangkat_desa.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan: ".mysqli_error($conn)."');window.location='read_perangkat_desa.php';</script>";
}
?>
