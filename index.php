<?php
session_start();
include 'koneksi.php';

// Ambil data statistik dari database
$q_warga       = mysqli_query($conn, "SELECT COUNT(*) AS total FROM warga");
$q_kegiatan    = mysqli_query($conn, "SELECT COUNT(*) AS total FROM kegiatan");
$q_partisipasi = mysqli_query($conn, "SELECT COUNT(*) AS total FROM partisipasi");
$q_perangkat   = mysqli_query($conn, "SELECT COUNT(*) AS total FROM perangkat_desa");

$jumlah_warga       = mysqli_fetch_assoc($q_warga)['total'];
$jumlah_kegiatan    = mysqli_fetch_assoc($q_kegiatan)['total'];
$total_partisipasi  = mysqli_fetch_assoc($q_partisipasi)['total'];
$jumlah_perangkat   = mysqli_fetch_assoc($q_perangkat)['total'];

// Set zona waktu ke WIB
date_default_timezone_set('Asia/Jakarta');

// ✅ Sapaan waktu lebih detail
$jam = date('H');
if ($jam >= 5 && $jam < 12) {
    $sapaan = "Selamat pagi";
} elseif ($jam >= 12 && $jam < 15) {
    $sapaan = "Selamat siang";
} elseif ($jam >= 15 && $jam < 18) {
    $sapaan = "Selamat sore";
} else {
    $sapaan = "Selamat malam";
}
$tanggal = date('l, d F Y');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Perangkat Desa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar h4 {
            padding: 20px;
            border-bottom: 1px solid #495057;
            background: #212529;
            margin: 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            transition: background 0.2s ease;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
        }
        .card-dashboard {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-dashboard:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .stat-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 15px;
            text-align: center;
        }
        .stat-box h6 {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }
        .stat-box p {
            font-size: 20px;
            margin: 5px 0 0;
            font-weight: bold;
        }
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>🌾 Aplikasi Desa</h4>
    <a href="index.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="read_warga.php"><i class="bi bi-people-fill"></i> Data Warga</a>
    <a href="read_kegiatan.php"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
    <a href="read_keuangan.php"><i class="bi bi-cash-stack"></i> Data Keuangan</a>
    <a href="read_partisipasi.php"><i class="bi bi-check2-circle"></i> Partisipasi</a>
    <a href="read_perangkat_desa.php"><i class="bi bi-person-badge"></i> Perangkat Desa</a>
    <a href="read_laporan_kegiatan.php"><i class="bi bi-file-earmark-text"></i> Laporan Kegiatan</a>
</div>

<!-- Content -->
<div class="content">
    <!-- Sambutan -->
    <div class="card shadow-sm mb-4 fade-in">
        <div class="card-body bg-light d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">👋 <?= $sapaan ?>, <strong>Admin Desa</strong>!</h4>
                <p class="text-muted mb-1">Hak Akses: <span class="badge bg-info">admin</span></p>
                <p class="mb-0">Silakan pilih menu di sidebar untuk mengelola data.</p>
            </div>
            <div class="text-end text-muted small">
                <i class="bi bi-calendar-event"></i> <?= $tanggal ?>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="row mb-4 g-3">
        <div class="col-md-3 col-6">
            <div class="stat-box">
                <h6>Jumlah Warga</h6>
                <p><?= $jumlah_warga ?></p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-box">
                <h6>Jumlah Kegiatan</h6>
                <p><?= $jumlah_kegiatan ?></p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-box">
                <h6>Total Partisipasi</h6>
                <p><?= $total_partisipasi ?></p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-box">
                <h6>Perangkat Desa</h6>
                <p><?= $jumlah_perangkat ?></p>
            </div>
        </div>
    </div>

    <!-- Menu Tiles -->
    <div class="row g-4">
        <?php
        $menu = [
            ["Data Warga", "read_warga.php", "bi-people-fill", "primary"],
            ["Data Kegiatan", "read_kegiatan.php", "bi-calendar-event", "success"],
            ["Data Keuangan", "read_keuangan.php", "bi-cash-stack", "warning"],
            ["Partisipasi", "read_partisipasi.php", "bi-check2-circle", "info"],
            ["Perangkat Desa", "read_perangkat_desa.php", "bi-person-badge", "secondary"],
            ["Laporan Kegiatan", "read_laporan_kegiatan.php", "bi-file-earmark-text", "dark"]
        ];
        foreach ($menu as $item) {
        ?>
        <div class="col-md-4 col-sm-6">
            <div class="card card-dashboard text-center">
                <div class="card-body">
                    <i class="bi <?= $item[2] ?> display-4 text-<?= $item[3] ?>"></i>
                    <h5 class="mt-2"><?= $item[0] ?></h5>
                    <a href="<?= $item[1] ?>" class="btn btn-outline-<?= $item[3] ?>">Kelola</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

</body>
</html>






