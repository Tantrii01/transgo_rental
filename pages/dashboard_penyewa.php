<?php
session_start();
include '../config/koneksi.php';

// Pastikan user sudah login dan berperan sebagai penyewa
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'penyewa') {
    header("Location: ../login.php");
    exit;
}

// Ambil semua mobil yang statusnya tersedia
$query = "SELECT * FROM mobil WHERE status = 'tersedia'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyewa - TransGo Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f7ff; /* Biru sangat muda */
        }
        
        /* Navbar Custom */
        .navbar {
            background: linear-gradient(to right, #0d47a1, #1976d2);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }

        /* Alert Styling */
        .alert-custom {
            background-color: #ffffff;
            border-left: 5px solid #ff9800; /* Aksen Orange */
            color: #333;
            border-radius: 10px;
        }

        /* Card Mobil Styling */
        .card-mobil {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
            background: #fff;
        }
        .card-mobil:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .price-tag {
            color: #fb8c00;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* Button Styling */
        .btn-sewa {
            background: linear-gradient(45deg, #ff9800, #fb8c00);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            margin-top: 5px;
        }
        .btn-sewa:hover {
            background: linear-gradient(45deg, #fb8c00, #f57c00);
            color: white;
            box-shadow: 0 4px 12px rgba(251, 140, 0, 0.3);
        }
        .btn-outline-info-custom {
            border: 2px solid #0d47a1;
            color: #0d47a1;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-outline-info-custom:hover {
            background-color: #0d47a1;
            color: white;
        }
        
        h3 { color: #0d47a1; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">TRANSGO <span style="color: #ff9800;">RENTAL</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="dashboard_penyewa.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="riwayat_pemesanan.php">Riwayat Pemesanan</a>
        </li>
        <li class="nav-item ms-lg-3">
          <a class="btn btn-sm btn-danger px-3" style="border-radius: 20px;" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <div class="alert alert-custom shadow-sm d-flex align-items-center mb-5" role="alert">
        <div>
            Halo, <span class="fw-bold"><?= htmlspecialchars($_SESSION['nama']); ?></span>! Selamat datang kembali. Pilih mobil impian Anda hari ini.
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Katalog Mobil</h3>
        <span class="badge bg-primary px-3 py-2" style="border-radius: 20px;">Tersedia</span>
    </div>

    <div class="row">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-mobil shadow-sm h-100">
                        <?php
                        $imageFile = !empty($row['gambar']) ? '../assets/images/' . htmlspecialchars($row['gambar']) : '../assets/images/default.jpg';
                        ?>
                        <img src="<?= $imageFile ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_mobil']); ?>">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-1"><?= htmlspecialchars($row['nama_mobil']); ?></h5>
                            <p class="price-tag mb-3">Rp <?= number_format((float)$row['harga_sewa'], 0, ',', '.'); ?> <small class="text-muted fw-normal">/ hari</small></p>
                            
                            <div class="mt-auto">
                                <a href="detail_mobil.php?id=<?= $row['id_mobil']; ?>" class="btn btn-outline-info-custom w-100 mb-2">Lihat Detail</a>
                                <a href="form_pemesanan.php?id=<?= (int)$row['id_mobil']; ?>" class="btn btn-sewa w-100">Sewa Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <img src="https://illustrations.popsy.co/blue/waiting-for-something.svg" alt="empty" style="width: 200px;" class="mb-3">
                <p class="text-muted fs-5">Maaf, saat ini belum ada mobil yang tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="text-center py-4 mt-5 text-muted small">
    &copy; <?= date('Y'); ?> TransGo Rental. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>