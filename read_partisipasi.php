<?php
session_start(); // wajib di awal file
include 'koneksi.php';

$sql = "SELECT p.id_partisipasi, w.nama AS nama_warga, k.nama_kegiatan, 
               p.peran, p.kehadiran, p.hak_akses
        FROM partisipasi p
        JOIN warga w ON p.id_warga = w.id_warga
        JOIN kegiatan k ON p.id_kegiatan = k.id_kegiatan";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Partisipasi</title>
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
        <h2 class="m-0">Data Partisipasi</h2>
    </div>

    <!-- Tombol hijau -->
    <a href="create_partisipasi.php" class="btn btn-success mb-3">Tambah Partisipasi</a>

    <!-- Tabel partisipasi -->
    <table id="partisipasiTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Partisipasi</th>
                <th>Nama Warga</th>
                <th>Nama Kegiatan</th>
                <th>Peran</th>
                <th>Kehadiran</th>
                <th>Hak Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id_partisipasi']) ?></td>
                <td><?= htmlspecialchars($row['nama_warga']) ?></td>
                <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['peran']) ?></td>
                <td><?= htmlspecialchars($row['kehadiran']) ?></td>
                <td><?= htmlspecialchars($row['hak_akses']) ?></td>
                <td>
                    <a href="update_partisipasi.php?id_partisipasi=<?= $row['id_partisipasi'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_partisipasi.php?id_partisipasi=<?= $row['id_partisipasi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</a>
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
            $('#partisipasiTable').DataTable({
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


