<?php
session_start(); // wajib di awal file
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama      = trim($_POST['nama']);
    $jabatan   = $_POST['jabatan'];
    $jabatan_lainnya = $_POST['jabatan_lainnya'] ?? '';
    $kontak    = trim($_POST['kontak']);
    $hak_akses = $_POST['hak_akses'];

    // ✅ Kalau pilih "Lainnya", ambil dari input tambahan
    if ($jabatan === "Lainnya" && !empty($jabatan_lainnya)) {
        $jabatan = $jabatan_lainnya;
    }

    $sql = "INSERT INTO perangkat_desa 
            (nama, jabatan, kontak, hak_akses)
            VALUES 
            ('$nama', '$jabatan', '$kontak', '$hak_akses')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data perangkat desa berhasil ditambahkan');window.location='read_perangkat_desa.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Perangkat Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Tambah Perangkat Desa</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="jabatan" id="jabatan" class="form-select" required onchange="toggleJabatanLainnya()">
                <option value="">-- Pilih Jabatan --</option>
                <option value="Kepala Desa">Kepala Desa</option>
                <option value="Sekretaris Desa">Sekretaris Desa</option>
                <option value="Kaur Keuangan">Kaur Keuangan</option>
                <option value="Kaur Umum/Perencanaan">Kaur Umum/Perencanaan</option>
                <option value="Kasi Pemerintahan">Kasi Pemerintahan</option>
                <option value="Kasi Kesejahteraan">Kasi Kesejahteraan</option>
                <option value="Kasi Pelayanan">Kasi Pelayanan</option>
                <option value="Kepala Dusun">Kepala Dusun</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <small class="form-text text-muted">Pilih jabatan sesuai struktur perangkat desa. Jika tidak ada, pilih "Lainnya".</small>
        </div>
        <div class="mb-3" id="jabatan_lainnya_group" style="display:none;">
            <label class="form-label">Jabatan Lainnya</label>
            <input type="text" name="jabatan_lainnya" class="form-control">
            <small class="form-text text-muted">Isi jika memilih "Lainnya".</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Hak Akses</label>
            <select name="hak_akses" class="form-select" required>
                <option value="">-- Pilih Hak Akses --</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
                <option value="Viewer">Viewer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="read_perangkat_desa.php" class="btn btn-secondary">Kembali</a>
    </form>

    <script>
    function toggleJabatanLainnya() {
        const select = document.getElementById("jabatan");
        const lainnyaGroup = document.getElementById("jabatan_lainnya_group");
        lainnyaGroup.style.display = (select.value === "Lainnya") ? "block" : "none";
    }
    </script>
</body>
</html>

