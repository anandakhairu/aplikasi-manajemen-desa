<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kegiatan      = trim($_POST['nama_kegiatan']);
    $jenis_kegiatan     = $_POST['jenis_kegiatan'];
    $jenis_kegiatan_lainnya = $_POST['jenis_kegiatan_lainnya'] ?? '';
    $lokasi_kegiatan    = trim($_POST['lokasi_kegiatan']);
    $tujuan_kegiatan    = trim($_POST['tujuan_kegiatan']);
    $tanggal_mulai      = $_POST['tanggal_mulai'];
    $tanggal_selesai    = $_POST['tanggal_selesai'];
    $deskripsi          = trim($_POST['deskripsi']);
    $kebutuhan_logistik = trim($_POST['kebutuhan_logistik']);
    $hasil_evaluasi     = trim($_POST['hasil_evaluasi']);
    $dokumentasi_url    = trim($_POST['dokumentasi_url']);

    // ✅ Kalau pilih "Lainnya", ambil dari input tambahan
    if ($jenis_kegiatan === "Lainnya" && !empty($jenis_kegiatan_lainnya)) {
        $jenis_kegiatan = $jenis_kegiatan_lainnya;
    }

    // ✅ Validasi Dokumentasi URL (opsional, boleh kosong)
    if (!empty($dokumentasi_url) && !filter_var($dokumentasi_url, FILTER_VALIDATE_URL)) {
        die("<script>alert('Dokumentasi URL tidak valid!');history.back();</script>");
    }

    $sql = "INSERT INTO kegiatan 
            (nama_kegiatan, jenis_kegiatan, lokasi_kegiatan, tujuan_kegiatan, tanggal_mulai, tanggal_selesai, deskripsi, kebutuhan_logistik, hasil_evaluasi, dokumentasi_url)
            VALUES 
            ('$nama_kegiatan', '$jenis_kegiatan', '$lokasi_kegiatan', '$tujuan_kegiatan', '$tanggal_mulai', '$tanggal_selesai', '$deskripsi', '$kebutuhan_logistik', '$hasil_evaluasi', '$dokumentasi_url')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data kegiatan berhasil ditambahkan');window.location='read_kegiatan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kegiatan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Tambah Kegiatan</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kegiatan</label>
            <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-select" required onchange="toggleJenisLainnya()">
                <option value="">-- Pilih Jenis Kegiatan --</option>
                <option value="Sosialisasi">Sosialisasi</option>
                <option value="Gotong Royong">Gotong Royong</option>
                <option value="Pelatihan">Pelatihan</option>
                <option value="Musyawarah">Musyawarah</option>
                <option value="Lomba">Lomba</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <small class="form-text text-muted">Pilih jenis kegiatan. Jika tidak ada, pilih "Lainnya".</small>
        </div>
        <div class="mb-3" id="jenis_lainnya_group" style="display:none;">
            <label class="form-label">Jenis Kegiatan Lainnya</label>
            <input type="text" name="jenis_kegiatan_lainnya" class="form-control">
            <small class="form-text text-muted">Isi jika memilih "Lainnya".</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi Kegiatan</label>
            <input type="text" name="lokasi_kegiatan" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tujuan Kegiatan</label>
            <textarea name="tujuan_kegiatan" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Kebutuhan Logistik</label>
            <textarea name="kebutuhan_logistik" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Hasil Evaluasi</label>
            <textarea name="hasil_evaluasi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Dokumentasi URL</label>
            <input type="url" name="dokumentasi_url" class="form-control"
                   placeholder="https://drive.google.com/..." 
                   pattern="https?://.+" 
                   title="Masukkan URL yang valid dimulai dengan http:// atau https://">
            <small class="form-text text-muted">Masukkan tautan ke dokumentasi kegiatan (Drive, YouTube, dll).</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
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


