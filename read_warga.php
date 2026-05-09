<?php
session_start(); 
include 'koneksi.php';

$sql = "SELECT * FROM warga";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Warga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .judul-box {
            background-color: #0d6efd; /* biru */
            color: white;
            padding: 15px 25px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .table thead {
            background-color: #000; /* header hitam */
            color: white;
        }
    </style>
</head>
<body class="container mt-5">

    <div class="judul-box">
        <h2 class="m-0">Data Warga</h2>
    </div>

    <a href="create_warga.php" class="btn btn-success mb-3">Tambah Warga</a>

    <table id="wargaTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Status Keluarga</th>
                <th>No KK</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Status Warga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id_warga'] ?></td>
                    <td><?= $row['nik'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['jenis_kelamin'] ?></td>
                    <td><?= $row['tanggal_lahir'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    <td><?= $row['status_keluarga'] ?></td>
                    <td><?= $row['no_kk'] ?></td>
                    <td><?= $row['pekerjaan'] ?></td>
                    <td><?= $row['pendidikan'] ?></td>
                    <td><?= $row['status_warga'] ?></td>
                    <td>
                        <a href="update_warga.php?id_warga=<?= $row['id_warga'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_warga.php?id_warga=<?= $row['id_warga'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#wargaTable').DataTable({
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







