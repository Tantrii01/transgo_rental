<?php
session_start();
include("../config/koneksi.php");

// Pastikan hanya pemilik/admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pemilik') {
    header("Location: ../login.php");
    exit();
}

// Ambil ID pemesanan dari URL dan amankan
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $update = "UPDATE sewa SET status='dikonfirmasi' WHERE id_sewa=$id";
    mysqli_query($conn, $update);
}

// Kembali ke halaman kelola pemesanan
header("Location: kelola_pemesanan.php");
exit;
?>
