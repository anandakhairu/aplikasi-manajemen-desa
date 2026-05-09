<?php
session_start(); // wajib di awal file
include 'koneksi.php';

$id_partisipasi = intval($_GET['id_partisipasi']);
$sql = "SELECT * FROM partisipasi WHERE id_partisipasi='$id_partisipasi'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

$warga    = mysqli_query($conn, "SELECT id_warga, nama FROM warga");
$kegiatan = mysqli_query($conn, "SELECT id_kegiatan, nama_kegiatan FROM kegiatan");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_warga    = $_POST['id_warga'];
    $id_kegiatan = $_POST['id_kegiatan'];
    $peran       = trim($_POST['peran']);
    $kehadiran   = $_POST['kehadiran'];
    $hak_akses   = $_POST['hak_akses'];

    $sql_update = "UPDATE partisipasi SET 
                    id_warga='$id_warga',
                    id_kegiatan='$id_kegiatan',
                    peran='$peran',
                    kehadiran='$kehadiran',
                    hak_akses='$hak_akses'
                  WHERE id_partisipasi='$id_partisipasi'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Data partisipasi berhasil diupdate');window.location='read_partisipasi.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Partisipasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Update Partisipasi</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Nama Warga</label>
            <select name="id_warga" class="form-select" required>
                <?php while($row = mysqli_fetch_assoc($warga)) { ?>
                    <option value="<?= htmlspecialchars($row['id_warga']) ?>" <?= ($data['id_warga']==$row['id_warga'])?'selected':'' ?>>
                        <?= htmlspecialchars($row['nama']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Kegiatan</label>
            <select name="id_kegiatan" class="form-select" required>
                <?php while($row = mysqli_fetch_assoc($kegiatan)) { ?>
                    <option value="<?= htmlspecialchars($row['id_kegiatan']) ?>" <?= ($data['id_kegiatan']==$row['id_kegiatan'])?'selected':'' ?>>
                        <?= htmlspecialchars($row['nama_kegiatan']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Peran</label>
            <input type="text" name="peran" class="form-control" 
                   value="<?= htmlspecialchars($data['peran']) ?>" 
                   placeholder="Contoh: Peserta, Panitia, Pemateri" required>
            <small class="form-text text-muted">Tulis peran sesuai kontribusi dalam kegiatan.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Kehadiran</label>
            <select name="kehadiran" class="form-select" required>
                <option value="Hadir" <?= ($data['kehadiran']=='Hadir')?'selected':'' ?>>Hadir</option>
                <option value="Tidak Hadir" <?= ($data['kehadiran']=='Tidak Hadir')?'selected':'' ?>>Tidak Hadir</option>
            </select>
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
        <a href="read_partisipasi.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>


