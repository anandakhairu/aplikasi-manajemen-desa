<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik             = trim($_POST['nik']);
    $nama            = trim($_POST['nama']);
    $jenis_kelamin   = $_POST['jenis_kelamin'];
    $tanggal_lahir   = $_POST['tanggal_lahir'];
    $alamat          = trim($_POST['alamat']);
    $status_keluarga = $_POST['status_keluarga']; 
    $no_kk           = trim($_POST['no_kk']);
    $pekerjaan       = trim($_POST['pekerjaan']);
    $pendidikan      = $_POST['pendidikan'];
    $status_warga    = $_POST['status_warga'];

    // ✅ Validasi NIK harus 16 digit angka
    if(strlen($nik) != 16 || !ctype_digit($nik)) {
        die("<script>alert('NIK harus 16 digit angka!');history.back();</script>");
    }

    // ✅ Cek NIK unik
    $cek = mysqli_query($conn, "SELECT * FROM warga WHERE nik='$nik'");
    if(mysqli_num_rows($cek) > 0){
        die("<script>alert('NIK sudah terdaftar!');history.back();</script>");
    }

    // ✅ Validasi No KK harus 16 digit angka
    if(strlen($no_kk) != 16 || !ctype_digit($no_kk)) {
        die("<script>alert('No KK harus 16 digit angka!');history.back();</script>");
    }

    // ✅ Validasi tanggal lahir tidak boleh kosong
    if(empty($tanggal_lahir)){
        die("<script>alert('Tanggal lahir wajib diisi!');history.back();</script>");
    }

    // ✅ Insert data jika lolos validasi
    $sql = "INSERT INTO warga 
            (nik, nama, jenis_kelamin, tanggal_lahir, alamat, status_keluarga, no_kk, pekerjaan, pendidikan, status_warga)
            VALUES 
            ('$nik', '$nama', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$status_keluarga', '$no_kk', '$pekerjaan', '$pendidikan', '$status_warga')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data warga berhasil ditambahkan');window.location='read_warga.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Warga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Tambah Warga</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control" 
                   required pattern="[0-9]{16}" 
                   title="NIK harus 16 digit angka">
            <small class="form-text text-muted">Masukkan NIK yang terdiri dari 16 digit angka.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status Keluarga</label>
            <select name="status_keluarga" class="form-select" required>
                <option value="">-- Pilih Status Keluarga --</option>
                <option value="Kepala Keluarga">Kepala Keluarga</option>
                <option value="Istri">Istri</option>
                <option value="Anak">Anak</option>
                <option value="Orang Tua">Orang Tua</option>
                <option value="Saudara">Saudara</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">No KK</label>
            <input type="text" name="no_kk" class="form-control" 
                   required pattern="[0-9]{16}" 
                   title="No KK harus 16 digit angka">
            <small class="form-text text-muted">Masukkan No KK yang terdiri dari 16 digit angka.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Pendidikan</label>
            <select name="pendidikan" class="form-select">
                <option value="">-- Pilih Pendidikan --</option>
                <option value="Tidak Sekolah">Tidak Sekolah</option>
                <option value="SD">SD</option>
                <option value="SMP">SMP</option>
                <option value="SMA">SMA</option>
                <option value="Diploma">Diploma</option>
                <option value="Sarjana">Sarjana</option>
                <option value="Magister">Magister</option>
                <option value="Doktor">Doktor</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status Warga</label>
            <select name="status_warga" class="form-select">
                <option value="">-- Pilih Status Warga --</option>
                <option value="Tetap">Tetap</option>
                <option value="Pendatang">Pendatang</option>
                <option value="Meninggal">Meninggal</option>
                <option value="Pindah">Pindah</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="read_warga.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>



