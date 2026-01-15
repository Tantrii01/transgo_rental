<?php
include("../config/koneksi.php");

$id = $_GET['id'];

// Ambil id_mobil dari data sewa
$q = mysqli_query($conn, "SELECT id_mobil FROM sewa WHERE id_sewa='$id'");
$data = mysqli_fetch_assoc($q);
$id_mobil = $data['id_mobil'];

// Update status sewa dan mobil
mysqli_query($conn, "UPDATE sewa SET status='selesai' WHERE id_sewa='$id'");
mysqli_query($conn, "UPDATE mobil SET status='tersedia' WHERE id_mobil='$id_mobil'");

header("Location: kelola_pemesanan.php?success=done");
exit();
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

?>
