<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../config/koneksi.php';

// Cek login & role
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'penyewa') {
    header("Location: ../login.php");
    exit;
}

// Ambil ID mobil dari URL
if (!isset($_GET['id'])) {
    header("Location: dashboard_penyewa.php");
    exit;
}

$id_mobil = (int)$_GET['id'];

// Ambil data mobil
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil = $id_mobil");
$mobil = mysqli_fetch_assoc($query);


if (!$mobil) {
    echo "<script>alert('Mobil tidak ditemukan!'); window.location='dashboard_penyewa.php';</script>";
    exit;
}

// Ambil nomor HP user dari tabel users
$id_user = $_SESSION['id_user'];
$userData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT no_wa FROM users WHERE id_user = '$id_user'"));
$no_wa = $userData['no_wa'] ?? '-';

// Jika form disubmit
if (isset($_POST['pesan'])) {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $no_wa = $_POST['no_wa'];

    // Hitung lama sewa (dalam hari)
    $mulai = new DateTime($tanggal_mulai);
    $selesai = new DateTime($tanggal_selesai);
    $lama = $mulai->diff($selesai)->days;

    if ($lama <= 0) {
        echo "<script>alert('Tanggal selesai harus setelah tanggal mulai!');</script>";
    } else {
        $total_harga = $lama * $mobil['harga_sewa'];

        // Simpan ke tabel sewa dengan nomor HP
        $sql = "INSERT INTO sewa (id_user, no_wa, id_mobil, tanggal_mulai, tanggal_selesai, total_harga, status)
                VALUES ('$id_user', '$no_wa', '$id_mobil', '$tanggal_mulai', '$tanggal_selesai', '$total_harga', 'pending')";
        $insert = mysqli_query($conn, $sql);

        if ($insert) {
            // Ubah status mobil jadi disewa
            mysqli_query($conn, "UPDATE mobil SET status='disewa' WHERE id_mobil=$id_mobil");

            echo "<script>alert('Pemesanan berhasil! Tunggu konfirmasi dari admin.'); window.location='riwayat_pemesanan.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal melakukan pemesanan!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - TransGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
            color: #444;
        }
        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .card-order {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .card-header-custom {
            background: #0d47a1; /* Biru Navy Soft */
            color: white;
            padding: 20px;
            border: none;
            text-align: center;
        }
        .card-header-custom h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }
        .car-info-box {
            background-color: #e3f2fd;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            border-left: 5px solid #fb8c00;
        }
        .form-label {
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dee2e6;
            transition: 0.3s;
        }
        .form-control:focus {
            box-shadow: 0 0 8px rgba(13, 71, 161, 0.1);
            border-color: #0d47a1;
        }
        .btn-order {
            background: linear-gradient(45deg, #ff9800, #fb8c00);
            border: none;
            color: white;
            padding: 14px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn-order:hover {
            background: linear-gradient(45deg, #fb8c00, #f57c00);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 140, 0, 0.3);
            color: white;
        }
        .btn-back {
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-back:hover {
            color: #0d47a1;
        }
        .price-badge {
            color: #fb8c00;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
            <div class="card card-order shadow">
                <div class="card-header-custom">
                    <h4>Pemesanan Unit</h4>
                </div>

                <div class="card-body p-4">
                    <div class="car-info-box">
                        <h6 class="mb-1 fw-bold text-dark"><?= htmlspecialchars($mobil['nama_mobil']); ?></h6>
                        <p class="mb-0 small text-muted">Tarif: <span class="price-badge">Rp <?= number_format($mobil['harga_sewa'], 0, ',', '.'); ?> / hari</span></p>
                    </div>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="no_wa" class="form-label">Nomor WhatsApp Aktif</label>
                            <input type="text" name="no_wa" id="no_wa" class="form-control" placeholder="Contoh: 08123456789" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" name="pesan" class="btn btn-order w-100 shadow-sm">
                            Konfirmasi Pesanan
                        </button>
                    </form>
                    
                    <div class="text-center">
                        <a href="dashboard_penyewa.php" class="btn-back">← Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>