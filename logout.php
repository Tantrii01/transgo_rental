<?php
session_start();
session_unset();   // Hapus semua variabel sesi
session_destroy(); // Hapus sesi sepenuhnya

// Arahkan kembali ke halaman login
header("Location: login.php");
exit();
?>
