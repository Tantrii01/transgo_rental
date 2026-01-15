<?php
session_start();
include("../config/koneksi.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'pemilik'){
    header("Location: ../login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0){
    die("ID pemesanan tidak valid");
}

// Ambil id_mobil
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_mobil FROM sewa WHERE id_sewa=$id"));
if(!$data){
    die("Pemesanan tidak ditemukan");
}

$id_mobil = $data['id_mobil'];

// Update status sewa jadi selesai
$update1 = mysqli_query($conn, "UPDATE sewa SET status='selesai' WHERE id_sewa=$id");
if(!$update1) die("Gagal update sewa: ".mysqli_error($conn));

// Update status mobil jadi tersedia
$update2 = mysqli_query($conn, "UPDATE mobil SET status='tersedia' WHERE id_mobil=$id_mobil");
if(!$update2) die("Gagal update mobil: ".mysqli_error($conn));

// Redirect kembali ke halaman kelola pemesanan
header("Location: kelola_pemesanan.php");
exit;
?>
