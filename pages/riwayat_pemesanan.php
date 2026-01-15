<?php
session_start();
include '../config/koneksi.php';

// Cek login dan role penyewa
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'penyewa') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data pemesanan milik user yang login, join dengan tabel mobil
$query = "
    SELECT s.*, m.nama_mobil, m.gambar, m.harga_sewa 
    FROM sewa s
    JOIN mobil m ON s.id_mobil = m.id_mobil
    WHERE s.id_user = '$id_user'
    ORDER BY s.id_sewa DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - TransGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
            color: #444;
        }

        /* Navbar Custom (Seragam) */
        .navbar {
            background: linear-gradient(to right, #0d47a1, #1976d2);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }

        /* Alert Styling */
        .alert-info-custom {
            background-color: #ffffff;
            border-left: 5px solid #0d47a1;
            color: #333;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* Card Styling */
        .card-history {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
            overflow: hidden;
            background: #fff;
            height: 100%;
        }
        .card-history:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
        }
        .img-history {
            height: 180px;
            object-fit: cover;
        }

        /* Status Badge Styling */
        .badge-status {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        .bg-pending { background-color: #fff3cd; color: #856404; }
        .bg-approved { background-color: #d4edda; color: #155724; }
        .bg-finished { background-color: #e2e3e5; color: #383d41; }

        .price-text {
            color: #fb8c00;
            font-weight: 600;
            font-size: 1.1rem;
        }
        h3 { color: #0d47a1; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard_penyewa.php">TRANSGO <span style="color: #ff9800;">RENTAL</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="dashboard_penyewa.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="riwayat_pemesanan.php">Riwayat Pemesanan</a>
        </li>
        <li class="nav-item ms-lg-3">
          <a class="btn btn-sm btn-danger px-3" style="border-radius: 20px;" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-5">
    <div class="alert alert-info-custom shadow-sm mb-5">
        Halo, <b><?= htmlspecialchars($_SESSION['nama']); ?></b> — Berikut adalah catatan perjalanan Anda.
    </div>

    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold m-0">Riwayat Pemesanan</h3>
    </div>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-history shadow-sm">
                        <img src="../assets/images/<?= htmlspecialchars($row['gambar']); ?>" 
                             class="img-history" 
                             alt="<?= htmlspecialchars($row['nama_mobil']); ?>">
                        
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3"><?= htmlspecialchars($row['nama_mobil']); ?></h5>
                            
                            <div class="mb-2 small text-muted">
                                <strong>Periode Sewa:</strong><br>
                                <span class="text-dark"><?= date('d M Y', strtotime($row['tanggal_mulai'])); ?> — <?= date('d M Y', strtotime($row['tanggal_selesai'])); ?></span>
                            </div>

                            <div class="mb-3">
                                <strong>Total Pembayaran:</strong><br>
                                <span class="price-text">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></span>
                            </div>

                            <hr class="text-muted opacity-25">

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="small fw-bold text-uppercase" style="font-size: 0.7rem; color: #999;">Status Pesanan</span>
                                <?php
                                $status = $row['status'];
                                if ($status == 'pending') {
                                    echo '<span class="badge-status bg-pending">Menunggu Konfirmasi</span>';
                                } elseif ($status == 'disetujui') {
                                    echo '<span class="badge-status bg-approved">Disetujui</span>';
                                } else {
                                    echo '<span class="badge-status bg-finished">Selesai</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <img src="https://illustrations.popsy.co/blue/abstract-art-4.svg" alt="empty" style="width: 180px;" class="mb-3 opacity-50">
            <p class="text-muted fs-5">Anda belum memiliki riwayat pemesanan.</p>
            <a href="dashboard_penyewa.php" class="btn btn-primary px-4 py-2" style="background: #0d47a1; border: none; border-radius: 10px;">Cari Mobil Sekarang</a>
        </div>
    <?php endif; ?>
</div>

<footer class="text-center py-4 text-muted small">
    &copy; <?= date('Y'); ?> TransGo Rental.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>