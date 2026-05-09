<?php
include 'koneksi.php';

// Ambil ID dari URL
$id_warga = $_GET['id_warga'];

// Ambil data warga berdasarkan ID
$sql = "SELECT * FROM warga WHERE id_warga='$id_warga'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

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

    // ✅ Cek NIK unik (tidak boleh sama dengan warga lain)
    $cek = mysqli_query($conn, "SELECT * FROM warga WHERE nik='$nik' AND id_warga!='$id_warga'");
    if(mysqli_num_rows($cek) > 0){
        die("<script>alert('NIK sudah dipakai warga lain!');history.back();</script>");
    }

    // ✅ Validasi No KK harus 16 digit angka
    if(strlen($no_kk) != 16 || !ctype_digit($no_kk)) {
        die("<script>alert('No KK harus 16 digit angka!');history.back();</script>");
    }

    // ✅ Validasi tanggal lahir tidak boleh kosong
    if(empty($tanggal_lahir)){
        die("<script>alert('Tanggal lahir wajib diisi!');history.back();</script>");
    }

    // ✅ Update data jika lolos validasi
    $sql_update = "UPDATE warga SET 
                    nik='$nik',
                    nama='$nama',
                    jenis_kelamin='$jenis_kelamin',
                    tanggal_lahir='$tanggal_lahir',
                    alamat='$alamat',
                    status_keluarga='$status_keluarga',
                    no_kk='$no_kk',
                    pekerjaan='$pekerjaan',
                    pendidikan='$pendidikan',
                    status_warga='$status_warga'
                  WHERE id_warga='$id_warga'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Data warga berhasil diupdate');window.location='read_warga.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Warga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Update Warga</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control" 
                   value="<?= $data['nik'] ?>" required pattern="[0-9]{16}" title="NIK harus 16 digit angka">
            <small class="form-text text-muted">Masukkan NIK yang terdiri dari 16 digit angka.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="Laki-laki" <?= ($data['jenis_kelamin']=='Laki-laki')?'selected':'' ?>>Laki-laki</option>
                <option value="Perempuan" <?= ($data['jenis_kelamin']=='Perempuan')?'selected':'' ?>>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="<?= $data['tanggal_lahir'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required><?= $data['alamat'] ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status Keluarga</label>
            <select name="status_keluarga" class="form-select" required>
                <option value="">-- Pilih Status Keluarga --</option>
                <option value="Kepala Keluarga" <?= ($data['status_keluarga']=='Kepala Keluarga')?'selected':'' ?>>Kepala Keluarga</option>
                <option value="Istri" <?= ($data['status_keluarga']=='Istri')?'selected':'' ?>>Istri</option>
                <option value="Anak" <?= ($data['status_keluarga']=='Anak')?'selected':'' ?>>Anak</option>
                <option value="Orang Tua" <?= ($data['status_keluarga']=='Orang Tua')?'selected':'' ?>>Orang Tua</option>
                <option value="Saudara" <?= ($data['status_keluarga']=='Saudara')?'selected':'' ?>>Saudara</option>
                <option value="Lainnya" <?= ($data['status_keluarga']=='Lainnya')?'selected':'' ?>>Lainnya</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">No KK</label>
            <input type="text" name="no_kk" class="form-control" 
                   value="<?= $data['no_kk'] ?>" required pattern="[0-9]{16}" title="No KK harus 16 digit angka">
            <small class="form-text text-muted">Masukkan No KK yang terdiri dari 16 digit angka.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control" value="<?= $data['pekerjaan'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Pendidikan</label>
            <select name="pendidikan" class="form-select">
                <option value="">-- Pilih Pendidikan --</option>
                <option value="Tidak Sekolah" <?= ($data['pendidikan']=='Tidak Sekolah')?'selected':'' ?>>Tidak Sekolah</option>
                <option value="SD" <?= ($data['pendidikan']=='SD')?'selected':'' ?>>SD</option>
                <option value="SMP" <?= ($data['pendidikan']=='SMP')?'selected':'' ?>>SMP</option>
                <option value="SMA" <?= ($data['pendidikan']=='SMA')?'selected':'' ?>>SMA</option>
                <option value="Diploma" <?= ($data['pendidikan']=='Diploma')?'selected':'' ?>>Diploma</option>
                <option value="Sarjana" <?= ($data['pendidikan']=='Sarjana')?'selected':'' ?>>Sarjana</option>
                <option value="Magister" <?= ($data['pendidikan']=='Magister')?'selected':'' ?>>Magister</option>
                <option value="Doktor" <?= ($data['pendidikan']=='Doktor')?'selected':'' ?>>Doktor</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status Warga</label>
            <select name="status_warga" class="form-select">
                <option value="">-- Pilih Status Warga --</option>
                <option value="Tetap" <?= ($data['status_warga']=='Tetap')?'selected':'' ?>>Tetap</option>
                <option value="Pendatang" <?= ($data['status_warga']=='Pendatang')?'selected':'' ?>>Pendatang</option>
                <option value="Meninggal" <?= ($data['status_warga']=='Meninggal')?'selected':'' ?>>Meninggal</option>
                <option value="Pindah" <?= ($data['status_warga']=='Pindah')?'selected':'' ?>>Pindah</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="read_warga.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>




