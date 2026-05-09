<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Ambil ID dari URL dengan aman
$id_perangkat = intval($_GET['id_perangkat']);

// Ambil data perangkat desa berdasarkan ID
$sql = "SELECT * FROM perangkat_desa WHERE id_perangkat='$id_perangkat'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

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

    // Update data perangkat desa
    $sql_update = "UPDATE perangkat_desa SET 
                    nama='$nama',
                    jabatan='$jabatan',
                    kontak='$kontak',
                    hak_akses='$hak_akses'
                  WHERE id_perangkat='$id_perangkat'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Data perangkat desa berhasil diupdate');window.location='read_perangkat_desa.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Perangkat Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Update Perangkat Desa</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" 
                   value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="jabatan" id="jabatan" class="form-select" required onchange="toggleJabatanLainnya()">
                <option value="">-- Pilih Jabatan --</option>
                <option value="Kepala Desa" <?= ($data['jabatan']=='Kepala Desa')?'selected':'' ?>>Kepala Desa</option>
                <option value="Sekretaris Desa" <?= ($data['jabatan']=='Sekretaris Desa')?'selected':'' ?>>Sekretaris Desa</option>
                <option value="Kaur Keuangan" <?= ($data['jabatan']=='Kaur Keuangan')?'selected':'' ?>>Kaur Keuangan</option>
                <option value="Kaur Umum/Perencanaan" <?= ($data['jabatan']=='Kaur Umum/Perencanaan')?'selected':'' ?>>Kaur Umum/Perencanaan</option>
                <option value="Kasi Pemerintahan" <?= ($data['jabatan']=='Kasi Pemerintahan')?'selected':'' ?>>Kasi Pemerintahan</option>
                <option value="Kasi Kesejahteraan" <?= ($data['jabatan']=='Kasi Kesejahteraan')?'selected':'' ?>>Kasi Kesejahteraan</option>
                <option value="Kasi Pelayanan" <?= ($data['jabatan']=='Kasi Pelayanan')?'selected':'' ?>>Kasi Pelayanan</option>
                <option value="Kepala Dusun" <?= ($data['jabatan']=='Kepala Dusun')?'selected':'' ?>>Kepala Dusun</option>
                <option value="Lainnya" <?= (!in_array($data['jabatan'], [
                    'Kepala Desa','Sekretaris Desa','Kaur Keuangan','Kaur Umum/Perencanaan',
                    'Kasi Pemerintahan','Kasi Kesejahteraan','Kasi Pelayanan','Kepala Dusun'
                ]))?'selected':'' ?>>Lainnya</option>
            </select>
            <small class="form-text text-muted">Pilih jabatan sesuai struktur perangkat desa. Jika tidak ada, pilih "Lainnya".</small>
        </div>
        <div class="mb-3" id="jabatan_lainnya_group" style="display:<?= (!in_array($data['jabatan'], [
            'Kepala Desa','Sekretaris Desa','Kaur Keuangan','Kaur Umum/Perencanaan',
            'Kasi Pemerintahan','Kasi Kesejahteraan','Kasi Pelayanan','Kepala Dusun'
        ]))?'block':'none' ?>;">
            <label class="form-label">Jabatan Lainnya</label>
            <input type="text" name="jabatan_lainnya" class="form-control" 
                   value="<?= (!in_array($data['jabatan'], [
                       'Kepala Desa','Sekretaris Desa','Kaur Keuangan','Kaur Umum/Perencanaan',
                       'Kasi Pemerintahan','Kasi Kesejahteraan','Kasi Pelayanan','Kepala Dusun'
                   ]))?htmlspecialchars($data['jabatan']):'' ?>">
            <small class="form-text text-muted">Isi jika memilih "Lainnya".</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" 
                   value="<?= htmlspecialchars($data['kontak']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Hak Akses</label>
            <select name="hak_akses" class="form-select" required>
                <option value="Admin" <?= ($data['hak_akses']=='Admin')?'selected':'' ?>>Admin</option>
                <option value="User" <?= ($data['hak_akses']=='User')?'selected':'' ?>>User</option>
                <option value="Viewer" <?= ($data['hak_akses']=='Viewer')?'selected':'' ?>>Viewer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
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

