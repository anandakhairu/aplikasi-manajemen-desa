<?php
session_start(); // wajib di awal file
include 'koneksi.php';

$message = "";
$type = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $message = "Data keuangan berhasil diproses!";
        $type = "success";
    } elseif ($_GET['status'] == 'error') {
        $message = "Terjadi kesalahan saat memproses data.";
        $type = "danger";
    }
}

$sql = "SELECT k.id_keuangan, p.nama AS nama_perangkat, g.nama_kegiatan, 
               k.jenis_transaksi, k.tanggal_transaksi, k.bukti_transaksi, 
               k.tahun_anggaran, k.nominal, k.hak_akses, k.keterangan 
        FROM keuangan k 
        LEFT JOIN perangkat_desa p ON k.id_perangkat = p.id_perangkat 
        LEFT JOIN kegiatan g ON k.id_kegiatan = g.id_kegiatan";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Keuangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .judul-box {
            background-color: #0d6efd;
            color: white;
            padding: 15px 25px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .table thead {
            background-color: #000;
            color: white;
        }
    </style>
</head>
<body class="container mt-5">

    <div class="judul-box">
        <h2 class="m-0">Data Keuangan</h2>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <a href="create_keuangan.php" class="btn btn-success mb-3">Tambah Keuangan</a>

    <table id="keuanganTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Perangkat Desa</th>
                <th>Kegiatan</th>
                <th>Jenis Transaksi</th>
                <th>Tanggal</th>
                <th>Bukti</th>
                <th>Tahun Anggaran</th>
                <th>Nominal</th>
                <th>Hak Akses</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id_keuangan'] ?></td>
                    <td><?= $row['nama_perangkat'] ?></td>
                    <td><?= $row['nama_kegiatan'] ?></td>
                    <td><?= $row['jenis_transaksi'] ?></td>
                    <td><?= $row['tanggal_transaksi'] ?></td>
                    <td>
                        <?php if(!empty($row['bukti_transaksi'])) { ?>
                            <img src="uploads/<?= htmlspecialchars($row['bukti_transaksi']) ?>" alt="Bukti" width="100">
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                    <td><?= $row['tahun_anggaran'] ?></td>
                    <td><?= number_format($row['nominal'], 0, ',', '.') ?></td>
                    <td><?= $row['hak_akses'] ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td>
                        <a href="update_keuangan.php?id_keuangan=<?= $row['id_keuangan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_keuangan.php?id_keuangan=<?= $row['id_keuangan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
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
            $('#keuanganTable').DataTable({
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







