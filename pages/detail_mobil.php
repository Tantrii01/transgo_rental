<?php
include("../config/koneksi.php");

// Ambil id dari URL, pastikan valid
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query data mobil
$result = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil=$id");

// Cek apakah data ada
if($result && mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);
} else {
    echo "Data mobil tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mobil - <?= htmlspecialchars($data['nama_mobil']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe; /* Biru pudar sangat lembut */
            color: #444;
            padding-bottom: 50px;
        }
        .container {
            margin-top: 50px;
        }
        .detail-card {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .img-container {
            padding: 20px;
            background: #fff;
            text-align: center;
        }
        .img-detail {
            width: 100%;
            max-width: 600px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .content-section {
            padding: 40px;
        }
        .car-name {
            color: #0d47a1; /* Biru Utama */
            font-weight: 600;
            margin-bottom: 10px;
        }
        .price-text {
            color: #fb8c00; /* Orange Lembut */
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .description-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            line-height: 1.8;
            color: #666;
            margin-bottom: 30px;
        }
        .btn-sewa {
            background: linear-gradient(45deg, #ff9800, #fb8c00);
            border: none;
            color: white;
            padding: 15px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        .btn-sewa:hover {
            background: linear-gradient(45deg, #fb8c00, #f57c00);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(251, 140, 0, 0.3);
            color: white;
        }
        .btn-back {
            color: #0d47a1;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .btn-back:hover {
            color: #fb8c00;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="dashboard_penyewa.php" class="btn-back">← Kembali ke Katalog</a>
    
    <div class="row detail-card g-0">
        <div class="col-lg-6 img-container d-flex align-items-center justify-content-center">
            <img src="../assets/images/<?= htmlspecialchars($data['gambar']); ?>" class="img-detail" alt="<?= htmlspecialchars($data['nama_mobil']); ?>">
        </div>
        
        <div class="col-lg-6 content-section">
            <h2 class="car-name"><?= htmlspecialchars($data['nama_mobil']); ?></h2>
            <div class="price-text">
                Rp <?= number_format($data['harga_sewa'], 0, ',', '.'); ?> <span style="font-size: 0.9rem; color: #888; font-weight: 400;">/ hari</span>
            </div>
            
            <h6 class="fw-bold text-dark">Deskripsi Mobil:</h6>
            <div class="description-box">
                <?= nl2br(htmlspecialchars($data['deskripsi'])); ?>
            </div>
            
            <a href="form_pemesanan.php?id=<?= (int)$data['id_mobil']; ?>" class="btn-sewa">
                Sewa Sekarang
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>