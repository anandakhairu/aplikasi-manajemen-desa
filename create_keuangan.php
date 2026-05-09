<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Ambil data perangkat dan kegiatan untuk dropdown
$perangkat = mysqli_query($conn, "SELECT id_perangkat, nama FROM perangkat_desa");
$kegiatan  = mysqli_query($conn, "SELECT id_kegiatan, nama_kegiatan FROM kegiatan");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_perangkat      = $_POST['id_perangkat'];
    $id_kegiatan       = $_POST['id_kegiatan'];
    $jenis_transaksi   = $_POST['jenis_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $tahun_anggaran    = $_POST['tahun_anggaran'];
    $nominal           = $_POST['nominal'];
    $hak_akses         = $_POST['hak_akses'];
    $keterangan        = $_POST['keterangan'];

    // ✅ Validasi tahun anggaran harus angka positif
    if(!is_numeric($tahun_anggaran) || $tahun_anggaran <= 0){
        die("<script>alert('Tahun anggaran harus berupa angka positif!');history.back();</script>");
    }

    // ✅ Validasi nominal harus angka positif
    if(!is_numeric($nominal) || $nominal <= 0){
        die("<script>alert('Nominal harus berupa angka positif!');history.back();</script>");
    }

    // ✅ Proses upload file bukti transaksi
    $bukti_transaksi = $_FILES['bukti_transaksi']['name'];
    $tmp_name        = $_FILES['bukti_transaksi']['tmp_name'];
    $target_dir      = "uploads/";
    $new_name        = time() . "_" . basename($bukti_transaksi);
    $target_file     = $target_dir . $new_name;

    if (!empty($bukti_transaksi)) {
        if (!move_uploaded_file($tmp_name, $target_file)) {
            die("<script>alert('Upload bukti transaksi gagal!');history.back();</script>");
        }
    } else {
        $new_name = ""; // jika tidak upload file
    }

    // ✅ Simpan ke database
    $sql = "INSERT INTO keuangan 
            (id_perangkat, id_kegiatan, jenis_transaksi, tanggal_transaksi, bukti_transaksi, tahun_anggaran, nominal, hak_akses, keterangan)
            VALUES 
            ('$id_perangkat', '$id_kegiatan', '$jenis_transaksi', '$tanggal_transaksi', '$new_name', '$tahun_anggaran', '$nominal', '$hak_akses', '$keterangan')";

    if (mysqli_query($conn, $sql)) {
        header("Location: read_keuangan.php?status=success");
        exit;
    } else {
        header("Location: read_keuangan.php?status=error");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Keuangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Tambah Data Keuangan</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Perangkat Desa</label>
            <select name="id_perangkat" class="form-select" required>
                <option value="">-- Pilih Perangkat --</option>
                <?php while($row = mysqli_fetch_assoc($perangkat)) { ?>
                    <option value="<?= $row['id_perangkat'] ?>"><?= $row['nama'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kegiatan</label>
            <select name="id_kegiatan" class="form-select" required>
                <option value="">-- Pilih Kegiatan --</option>
                <?php while($row = mysqli_fetch_assoc($kegiatan)) { ?>
                    <option value="<?= $row['id_kegiatan'] ?>"><?= $row['nama_kegiatan'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Transaksi</label>
            <select name="jenis_transaksi" class="form-select" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Pemasukan">Pemasukan</option>
                <option value="Pengeluaran">Pengeluaran</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bukti Transaksi</label>
            <input type="file" name="bukti_transaksi" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Tahun Anggaran</label>
            <input type="number" name="tahun_anggaran" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nominal</label>
            <input type="number" name="nominal" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hak Akses</label>
            <select name="hak_akses" class="form-select" required>
                <option value="">-- Pilih Hak Akses --</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
                <option value="Operator">Operator</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="read_keuangan.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>




