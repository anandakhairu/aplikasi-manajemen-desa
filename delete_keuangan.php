<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// lebih aman: pastikan id berupa angka
$id_keuangan = intval($_GET['id_keuangan']);

// ambil nama file bukti transaksi dulu
$result = mysqli_query($conn, "SELECT bukti_transaksi FROM keuangan WHERE id_keuangan='$id_keuangan'");
$data   = mysqli_fetch_assoc($result);

// hapus file bukti jika ada
if(!empty($data['bukti_transaksi'])){
    $file_path = "uploads/" . $data['bukti_transaksi'];
    if(file_exists($file_path)){
        unlink($file_path);
    }
}

// hapus data dari tabel
$sql = "DELETE FROM keuangan WHERE id_keuangan='$id_keuangan'";
if (mysqli_query($conn, $sql)) {
    header("Location: read_keuangan.php?status=success");
    exit;
} else {
    header("Location: read_keuangan.php?status=error");
    exit;
}
?>

