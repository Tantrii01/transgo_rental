<?php
session_start();
include("../config/koneksi.php");

// Proteksi akses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pemilik') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_mobil = $_GET['id'];
    $id_pemilik = $_SESSION['id_user'];

    // Pastikan mobil yang dihapus adalah milik pemilik yang sedang login
    $query = "DELETE FROM mobil WHERE id_mobil = '$id_mobil' AND id_pemilik = '$id_pemilik'";
    $delete = mysqli_query($conn, $query);

    if ($delete) {
        echo "<script>alert('Mobil berhasil dihapus dari armada!'); window.location='dashboard_pemilik.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus mobil: " . mysqli_error($conn) . "'); window.location='dashboard_pemilik.php';</script>";
    }
} else {
    header("Location: dashboard_pemilik.php");
}
?>