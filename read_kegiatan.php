<?php
session_start();
include 'koneksi.php';

$sql = "SELECT * FROM kegiatan";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kegiatan</title>
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
        <h2 class="m-0">Data Kegiatan</h2>
    </div>

    <a href="create_kegiatan.php" class="btn btn-success mb-3">Tambah Kegiatan</a>

    <table id="kegiatanTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kegiatan</th>
                <th>Jenis Kegiatan</th>
                <th>Lokasi</th>
                <th>Tujuan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Deskripsi</th>
                <th>Kebutuhan Logistik</th>
                <th>Hasil Evaluasi</th>
                <th>Dokumentasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id_kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['jenis_kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['lokasi_kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['tujuan_kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_selesai']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td><?= htmlspecialchars($row['kebutuhan_logistik']) ?></td>
                <td><?= htmlspecialchars($row['hasil_evaluasi']) ?></td>
                <td>
                    <?php if(!empty($row['dokumentasi_url'])) { ?>
                        <a href="<?= htmlspecialchars($row['dokumentasi_url']) ?>" target="_blank" class="btn btn-info btn-sm">Lihat Dokumentasi</a>
                    <?php } else { ?>
                        <span class="text-muted">Tidak ada</span>
                    <?php } ?>
                </td>
                <td>
                    <a href="edit_kegiatan.php?id_kegiatan=<?= $row['id_kegiatan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_kegiatan.php?id_kegiatan=<?= $row['id_kegiatan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus kegiatan ini?')">Delete</a>
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
            $('#kegiatanTable').DataTable({
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




