<?php
include 'koneksi.php';

// Ambil ID dari URL
$id_kegiatan = $_GET['id_kegiatan'];

// Ambil data kegiatan berdasarkan ID
$sql = "SELECT * FROM kegiatan WHERE id_kegiatan='$id_kegiatan'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kegiatan       = trim($_POST['nama_kegiatan']);
    $jenis_kegiatan      = $_POST['jenis_kegiatan'];
    $jenis_kegiatan_lain = $_POST['jenis_kegiatan_lainnya'] ?? '';
    $tanggal_mulai       = $_POST['tanggal_mulai'];
    $tanggal_selesai     = $_POST['tanggal_selesai'];
    $lokasi              = trim($_POST['lokasi']);
    $penanggung_jawab    = trim($_POST['penanggung_jawab']);
    $dokumentasi_url     = trim($_POST['dokumentasi_url']);

    // ✅ Kalau pilih "Lainnya", ambil dari input tambahan
    if ($jenis_kegiatan === "Lainnya" && !empty($jenis_kegiatan_lain)) {
        $jenis_kegiatan = $jenis_kegiatan_lain;
    }

    // ✅ Validasi tanggal tidak boleh kosong
    if(empty($tanggal_mulai) || empty($tanggal_selesai)){
        die("<script>alert('Tanggal mulai dan selesai wajib diisi!');history.back();</script>");
    }

    // ✅ Validasi tanggal selesai ≥ tanggal mulai
    if(strtotime($tanggal_selesai) < strtotime($tanggal_mulai)){
        die("<script>alert('Tanggal selesai tidak boleh sebelum tanggal mulai!');history.back();</script>");
    }

    // ✅ Validasi Dokumentasi URL (opsional, boleh kosong)
    if (!empty($dokumentasi_url) && !filter_var($dokumentasi_url, FILTER_VALIDATE_URL)) {
        die("<script>alert('Dokumentasi URL tidak valid!');history.back();</script>");
    }

    // ✅ Update data jika lolos validasi
    $sql_update = "UPDATE kegiatan SET 
                    nama_kegiatan='$nama_kegiatan',
                    jenis_kegiatan='$jenis_kegiatan',
                    tanggal_mulai='$tanggal_mulai',
                    tanggal_selesai='$tanggal_selesai',
                    lokasi='$lokasi',
                    penanggung_jawab='$penanggung_jawab',
                    dokumentasi_url='$dokumentasi_url'
                  WHERE id_kegiatan='$id_kegiatan'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Data kegiatan berhasil diupdate');window.location='read_kegiatan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Kegiatan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Update Kegiatan</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" 
                   value="<?= $data['nama_kegiatan'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kegiatan</label>
            <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-select" required onchange="toggleJenisLainnya()">
                <option value="">-- Pilih Jenis Kegiatan --</option>
                <option value="Sosialisasi" <?= ($data['jenis_kegiatan']=='Sosialisasi')?'selected':'' ?>>Sosialisasi</option>
                <option value="Gotong Royong" <?= ($data['jenis_kegiatan']=='Gotong Royong')?'selected':'' ?>>Gotong Royong</option>
                <option value="Pelatihan" <?= ($data['jenis_kegiatan']=='Pelatihan')?'selected':'' ?>>Pelatihan</option>
                <option value="Musyawarah" <?= ($data['jenis_kegiatan']=='Musyawarah')?'selected':'' ?>>Musyawarah</option>
                <option value="Lomba" <?= ($data['jenis_kegiatan']=='Lomba')?'selected':'' ?>>Lomba</option>
                <option value="Lainnya" <?= (!in_array($data['jenis_kegiatan'], ['Sosialisasi','Gotong Royong','Pelatihan','Musyawarah','Lomba']))?'selected':'' ?>>Lainnya</option>
            </select>
            <small class="form-text text-muted">Pilih jenis kegiatan. Jika tidak ada, pilih "Lainnya".</small>
        </div>
        <div class="mb-3" id="jenis_lainnya_group" style="display:<?= (!in_array($data['jenis_kegiatan'], ['Sosialisasi','Gotong Royong','Pelatihan','Musyawarah','Lomba']))?'block':'none' ?>;">
            <label class="form-label">Jenis Kegiatan Lainnya</label>
            <input type="text" name="jenis_kegiatan_lainnya" class="form-control" value="<?= (!in_array($data['jenis_kegiatan'], ['Sosialisasi','Gotong Royong','Pelatihan','Musyawarah','Lomba']))?$data['jenis_kegiatan']:'' ?>">
            <small class="form-text text-muted">Isi jika memilih "Lainnya".</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" 
                   value="<?= $data['tanggal_mulai'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" 
                   value="<?= $data['tanggal_selesai'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" class="form-control" value="<?= $data['penanggung_jawab'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Dokumentasi URL</label>
            <input type="url" name="dokumentasi_url" class="form-control"
                   value="<?= $data['dokumentasi_url'] ?>"
                   placeholder="https://drive.google.com/..." 
                   pattern="https?://.+" 
                   title="Masukkan URL yang valid dimulai dengan http:// atau https://">
            <small class="form-text text-muted">Masukkan tautan ke dokumentasi kegiatan (Drive, YouTube, dll).</small>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="read_kegiatan.php" class="btn btn-secondary">Kembali</a>
    </form>

    <script>
    function toggleJenisLainnya() {
        const select = document.getElementById("jenis_kegiatan");
        const lainnyaGroup = document.getElementById("jenis_lainnya_group");
        lainnyaGroup.style.display = (select.value === "Lainnya") ? "block" : "none";
    }
    </script>
</body>
</html>


