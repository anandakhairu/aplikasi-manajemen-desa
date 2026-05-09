<?php
session_start(); // wajib di awal file
include 'koneksi.php';

$sql = "SELECT l.id_laporan, k.nama_kegiatan, p.nama AS nama_perangkat, 
               l.uraian_hasil, l.kesimpulan, l.tanggal_laporan
        FROM laporan_kegiatan l
        JOIN kegiatan k ON l.id_kegiatan = k.id_kegiatan
        JOIN perangkat_desa p ON l.id_perangkat = p.id_perangkat";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Laporan Kegiatan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Judul box biru */
        .judul-box {
            background-color: #0d6efd;
            color: white;
            padding: 15px 25px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        /* Header tabel hitam */
        .table thead {
            background-color: #000;
            color: white;
        }
    </style>
</head>
<body class="container mt-5">

    <!-- Judul modul -->
    <div class="judul-box">
        <h2 class="m-0">Data Laporan Kegiatan</h2>
    </div>

    <!-- Tombol hijau -->
    <a href="create_laporan_kegiatan.php" class="btn btn-success mb-3">Tambah Laporan</a>

    <!-- Tabel laporan kegiatan -->
    <table id="laporanTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Laporan</th>
                <th>Nama Kegiatan</th>
                <th>Nama Perangkat Desa</th>
                <th>Uraian Hasil</th>
                <th>Kesimpulan</th>
                <th>Tanggal Laporan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id_laporan']) ?></td>
                <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['nama_perangkat']) ?></td>
                <td><?= htmlspecialchars($row['uraian_hasil']) ?></td>
                <td><?= htmlspecialchars($row['kesimpulan']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_laporan']) ?></td>
                <td>
                    <a href="update_laporan_kegiatan.php?id_laporan=<?= $row['id_laporan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_laporan_kegiatan.php?id_laporan=<?= $row['id_laporan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus laporan ini?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Script Bootstrap + jQuery + DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#laporanTable').DataTable({
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Kembali"
                    }
                }
            });
        });
    </script>
</body>
</html>



