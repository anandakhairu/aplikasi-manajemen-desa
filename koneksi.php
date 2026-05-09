<?php
$host     = 'localhost';
$username = 'root';
$password = '';
$db_name  = 'projek_desa'; 

$conn = new mysqli($host, $username, $password, $db_name);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>
