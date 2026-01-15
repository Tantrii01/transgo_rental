<?php
session_start();
include("../config/koneksi.php");

// Pastikan hanya pemilik yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pemilik') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik - TransGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
            color: #444;
        }

        /* Navbar Custom */
        .navbar {
            background: linear-gradient(to right, #0d47a1, #1976d2);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }

        .container {
            margin-top: 40px;
        }

        /* Card Styling */
        .card-panel {
            border: none;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 25px;
        }

        /* Table Styling */
        .table {
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }
        .table thead {
            background-color: #0d47a1;
            color: white;
            border: none;
        }
        .table th {
            font-weight: 500;
            padding: 15px;
            border: none;
        }
        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        /* Status Badge */
        .badge-soft {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.8rem;
        }
        .bg-tersedia { background-color: #d4edda; color: #155724; }
        .bg-disewa { background-color: #fff3cd; color: #856404; }

        /* Buttons Action */
        .btn-action {
            width: 35px;
            height: 35px;
            line-height: 35px;
            padding: 0;
            border-radius: 8px;
            display: inline-block;
            transition: 0.3s;
            text-align: center;
        }
        .btn-edit-car { background-color: #fff3cd; color: #856404; border: none; }
        .btn-edit-car:hover { background-color: #ffeeba; }
        .btn-delete-car { background-color: #f8d7da; color: #721c24; border: none; }
        .btn-delete-car:hover { background-color: #f5c6cb; }

        /* Buttons Main */
        .btn-tambah {
            background: linear-gradient(45deg, #ff9800, #fb8c00);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-tambah:hover {
            background: linear-gradient(45deg, #fb8c00, #f57c00);
            box-shadow: 0 5px 15px rgba(251, 140, 0, 0.3);
            color: white;
        }
        .btn-kelola {
            background-color: #f0f4f8;
            color: #0d47a1;
            border: 1px solid #0d47a1;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-kelola:hover {
            background-color: #0d47a1;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold" href="#">TRANSGO <span style="color: #ff9800;">ADMIN</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <span class="nav-link text-white me-3">Selamat Datang, <strong><?= $_SESSION['nama']; ?></strong></span>
        </li>
        <li class="nav-item">
          <a class="btn btn-sm btn-outline-light px-3" style="border-radius: 20px;" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold m-0" style="color: #0d47a1;">Panel Pengelolaan</h3>
            <p class="text-muted small">Kelola armada dan pantau pemesanan Anda</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="kelola_pemesanan.php" class="btn btn-kelola me-2">Kelola Pemesanan</a>
            <a href="tambah_mobil.php" class="btn btn-tambah shadow-sm">+ Tambah Mobil</a>
        </div>
    </div>

    <div class="card-panel shadow-sm">
        <h5 class="fw-bold mb-4">Daftar Mobil Anda</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Nama Mobil</th>
                        <th>Harga Sewa / Hari</th>
                        <th>Kapasitas</th>
                        <th>Status Armada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id_pemilik = $_SESSION['id_user'];
                    $result = mysqli_query($conn, "SELECT * FROM mobil WHERE id_pemilik='$id_pemilik' ORDER BY id_mobil DESC");
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status_class = ($row['status'] == 'tersedia') ? 'bg-tersedia' : 'bg-disewa';
                            ?>
                            <tr class="text-center">
                                <td class="text-start fw-bold"><?= $row['nama_mobil']; ?></td>
                                <td><span class="text-primary fw-bold">Rp <?= number_format($row['harga_sewa'], 0, ',', '.'); ?></span></td>
                                <td><?= $row['kapasitas']; ?> Orang</td>
                                <td>
                                    <span class="badge-soft <?= $status_class; ?>"><?= ucfirst($row['status']); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit.php?id=<?= $row['id_mobil']; ?>" class="btn-action btn-edit-car" title="Edit Mobil">
                                            <i class="fa fa-pen-to-square"></i>
                                        </a>
                                        <a href="hapus.php?id=<?= $row['id_mobil']; ?>" 
                                           class="btn-action btn-delete-car" 
                                           title="Hapus Mobil" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Belum ada mobil yang terdaftar.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>