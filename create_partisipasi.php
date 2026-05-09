<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Ambil data warga dan kegiatan untuk dropdown
$warga    = mysqli_query($conn, "SELECT id_warga, nama FROM warga");
$kegiatan = mysqli_query($conn, "SELECT id_kegiatan, nama_kegiatan FROM kegiatan");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_warga    = $_POST['id_warga'];
    $id_kegiatan = $_POST['id_kegiatan'];
    $peran       = trim($_POST['peran']);
    $kehadiran   = $_POST['kehadiran'];
    $hak_akses   = $_POST['hak_akses'];

    $sql = "INSERT INTO partisipasi 
            (id_warga, id_kegiatan, peran, kehadiran, hak_akses)
            VALUES 
            ('$id_warga', '$id_kegiatan', '$peran', '$kehadiran', '$hak_akses')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data partisipasi berhasil ditambahkan');window.location='read_partisipasi.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Partisipasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Tambah Partisipasi</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Nama Warga</label>
            <select name="id_warga" class="form-select" required>
                <option value="">-- Pilih Warga --</option>
                <?php while($row = mysqli_fetch_assoc($warga)) { ?>
                    <option value="<?= htmlspecialchars($row['id_warga']) ?>">
                        <?= htmlspecialchars($row['nama']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Kegiatan</label>
            <select name="id_kegiatan" class="form-select" required>
                <option value="">-- Pilih Kegiatan --</option>
                <?php while($row = mysqli_fetch_assoc($kegiatan)) { ?>
                    <option value="<?= htmlspecialchars($row['id_kegiatan']) ?>">
                        <?= htmlspecialchars($row['nama_kegiatan']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Peran</label>
            <input type="text" name="peran" class="form-control" 
                   placeholder="Contoh: Peserta, Panitia, Pemateri" required>
            <small class="form-text text-muted">Tulis peran sesuai kontribusi dalam kegiatan.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Kehadiran</label>
            <select name="kehadiran" class="form-select" required>
                <option value="">-- Pilih Kehadiran --</option>
                <option value="Hadir">Hadir</option>
                <option value="Tidak Hadir">Tidak Hadir</option>
            </select>
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
        <a href="read_partisipasi.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>


