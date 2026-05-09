<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Ambil ID laporan dari URL dengan aman
$id_laporan = intval($_GET['id_laporan']);

// Ambil data laporan berdasarkan ID
$sql = "SELECT * FROM laporan_kegiatan WHERE id_laporan='$id_laporan'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data laporan tidak ditemukan.");
}

// Ambil data kegiatan dan perangkat untuk dropdown
$kegiatan = mysqli_query($conn, "SELECT id_kegiatan, nama_kegiatan FROM kegiatan");
$perangkat = mysqli_query($conn, "SELECT id_perangkat, nama FROM perangkat_desa");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kegiatan      = $_POST['id_kegiatan'];
    $id_perangkat     = $_POST['id_perangkat'];
    $uraian_hasil     = $_POST['uraian_hasil'];
    $kesimpulan       = $_POST['kesimpulan'];
    $tanggal_laporan  = $_POST['tanggal_laporan'];

    $sql_update = "UPDATE laporan_kegiatan 
                   SET id_kegiatan='$id_kegiatan', 
                       id_perangkat='$id_perangkat', 
                       uraian_hasil='$uraian_hasil', 
                       kesimpulan='$kesimpulan', 
                       tanggal_laporan='$tanggal_laporan'
                   WHERE id_laporan='$id_laporan'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Data laporan berhasil diupdate');window.location='read_laporan_kegiatan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Laporan Kegiatan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Update Laporan Kegiatan</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Nama Kegiatan</label>
                    <select name="id_kegiatan" class="form-select" required>
                        <?php while($row = mysqli_fetch_assoc($kegiatan)) { ?>
                            <option value="<?= htmlspecialchars($row['id_kegiatan']) ?>" 
                                <?= ($row['id_kegiatan'] == $data['id_kegiatan']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nama_kegiatan']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Perangkat Desa</label>
                    <select name="id_perangkat" class="form-select" required>
                        <?php while($row = mysqli_fetch_assoc($perangkat)) { ?>
                            <option value="<?= htmlspecialchars($row['id_perangkat']) ?>" 
                                <?= ($row['id_perangkat'] == $data['id_perangkat']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nama']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Uraian Hasil</label>
                    <textarea name="uraian_hasil" class="form-control" required><?= htmlspecialchars($data['uraian_hasil']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kesimpulan</label>
                    <textarea name="kesimpulan" class="form-control" required><?= htmlspecialchars($data['kesimpulan']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Laporan</label>
                    <input type="date" name="tanggal_laporan" class="form-control" value="<?= htmlspecialchars($data['tanggal_laporan']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="read_laporan_kegiatan.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>

