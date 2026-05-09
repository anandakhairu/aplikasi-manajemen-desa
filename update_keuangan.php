<?php
session_start(); // wajib di awal file
include 'koneksi.php';

// Ambil ID dari URL
$id_keuangan = intval($_GET['id_keuangan']); // lebih aman

// Ambil data keuangan berdasarkan ID
$sql = "SELECT * FROM keuangan WHERE id_keuangan='$id_keuangan'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// Ambil data perangkat dan kegiatan untuk dropdown
$perangkat = mysqli_query($conn, "SELECT id_perangkat, nama FROM perangkat_desa");
$kegiatan  = mysqli_query($conn, "SELECT id_kegiatan, nama_kegiatan FROM kegiatan");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_perangkat   = $_POST['id_perangkat'];
    $id_kegiatan    = $_POST['id_kegiatan'];
    $tanggal        = $_POST['tanggal_transaksi'];
    $jenis          = $_POST['jenis_transaksi'];
    $nominal        = $_POST['nominal'];
    $tahun_anggaran = $_POST['tahun_anggaran'];
    $hak_akses      = $_POST['hak_akses'];
    $keterangan     = trim($_POST['keterangan']);

    // ✅ Validasi nominal harus angka positif
    if(!is_numeric($nominal) || $nominal <= 0){
        die("<script>alert('Nominal harus berupa angka positif!');history.back();</script>");
    }

    // ✅ Validasi tahun anggaran harus angka positif
    if(!is_numeric($tahun_anggaran) || $tahun_anggaran <= 0){
        die("<script>alert('Tahun anggaran harus berupa angka positif!');history.back();</script>");
    }

    // ✅ Validasi tanggal tidak boleh kosong
    if(empty($tanggal)){
        die("<script>alert('Tanggal wajib diisi!');history.back();</script>");
    }

    // ✅ Proses upload bukti transaksi (opsional)
    $bukti_sql = "";
    if (!empty($_FILES['bukti_transaksi']['name'])) {
        $bukti_transaksi = $_FILES['bukti_transaksi']['name'];
        $tmp_name        = $_FILES['bukti_transaksi']['tmp_name'];
        $target_dir      = "uploads/";
        $new_name        = time() . "_" . basename($bukti_transaksi);
        $target_file     = $target_dir . $new_name;

        // Hapus file lama jika ada
        if(!empty($data['bukti_transaksi'])){
            unlink("uploads/".$data['bukti_transaksi']);
        }

        if (move_uploaded_file($tmp_name, $target_file)) {
            $bukti_sql = ", bukti_transaksi='$new_name'";
        } else {
            die("<script>alert('Upload bukti transaksi gagal!');history.back();</script>");
        }
    }

    // ✅ Update data jika lolos validasi
    $sql_update = "UPDATE keuangan SET 
                    id_perangkat='$id_perangkat',
                    id_kegiatan='$id_kegiatan',
                    tanggal_transaksi='$tanggal',
                    jenis_transaksi='$jenis',
                    nominal='$nominal',
                    tahun_anggaran='$tahun_anggaran',
                    hak_akses='$hak_akses',
                    keterangan='$keterangan'
                    $bukti_sql
                  WHERE id_keuangan='$id_keuangan'";

    if (mysqli_query($conn, $sql_update)) {
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
    <title>Update Keuangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Update Keuangan</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Perangkat Desa</label>
            <select name="id_perangkat" class="form-select" required>
                <?php while($row = mysqli_fetch_assoc($perangkat)) { ?>
                    <option value="<?= $row['id_perangkat'] ?>" <?= ($data['id_perangkat']==$row['id_perangkat'])?'selected':'' ?>>
                        <?= $row['nama'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kegiatan</label>
            <select name="id_kegiatan" class="form-select" required>
                <?php while($row = mysqli_fetch_assoc($kegiatan)) { ?>
                    <option value="<?= $row['id_kegiatan'] ?>" <?= ($data['id_kegiatan']==$row['id_kegiatan'])?'selected':'' ?>>
                        <?= $row['nama_kegiatan'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" value="<?= $data['tanggal_transaksi'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Transaksi</label>
            <select name="jenis_transaksi" class="form-select" required>
                <option value="Pemasukan" <?= ($data['jenis_transaksi']=='Pemasukan')?'selected':'' ?>>Pemasukan</option>
                <option value="Pengeluaran" <?= ($data['jenis_transaksi']=='Pengeluaran')?'selected':'' ?>>Pengeluaran</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nominal</label>
            <input type="number" name="nominal" class="form-control" value="<?= $data['nominal'] ?>" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tahun Anggaran</label>
            <input type="number" name="tahun_anggaran" class="form-control" value="<?= $data['tahun_anggaran'] ?>" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hak Akses</label>
            <select name="hak_akses" class="form-select" required>
                <option value="Admin" <?= ($data['hak_akses']=='Admin')?'selected':'' ?>>Admin</option>
                <option value="User" <?= ($data['hak_akses']=='User')?'selected':'' ?>>User</option>
                <option value="Operator" <?= ($data['hak_akses']=='Operator')?'selected':'' ?>>Operator</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control"><?= $data['keterangan'] ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Bukti Transaksi (Upload baru jika ingin ganti)</label>
            <input type="file" name="bukti_transaksi" class="form-control" accept="image/*">
            <?php if(!empty($data['bukti_transaksi'])) { ?>
                <p class="mt-2">Bukti lama: <img src="uploads/<?= $data['bukti_transaksi'] ?>" width="100"></p>
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="read_keuangan.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>





