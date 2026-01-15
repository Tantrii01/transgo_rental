<?php
session_start();
include("../config/koneksi.php");

// Pastikan hanya pemilik yang bisa akses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pemilik') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['tambah'])) {
    $id_pemilik = $_SESSION['id_user'];
    $nama_mobil = $_POST['nama_mobil'];
    $harga = $_POST['harga_sewa'];
    $kapasitas = $_POST['kapasitas'];
    $deskripsi = $_POST['deskripsi'];

    // Upload foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    // Pastikan folder penyimpanan ada
    $folder = "../assets/images/";
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $path = $folder . basename($foto);

    if (move_uploaded_file($tmp, $path)) {
        $sql = "INSERT INTO mobil (id_pemilik, nama_mobil, harga_sewa, kapasitas, deskripsi, gambar)
                VALUES ('$id_pemilik', '$nama_mobil', '$harga', '$kapasitas', '$deskripsi', '$foto')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo "<script>alert('Mobil berhasil ditambahkan!'); window.location='dashboard_pemilik.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan mobil ke database: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Upload foto gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil - Pemilik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe; /* Biru pudar sangat lembut */
            color: #444;
        }
        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .card-custom {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
        }
        .card-header-custom {
            background-color: #0d47a1; /* Biru Navy Soft */
            color: white;
            padding: 25px;
            text-align: center;
            border: none;
        }
        .card-header-custom h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 10px rgba(13, 71, 161, 0.1);
            border-color: #0d47a1;
            background-color: #fff;
        }
        /* Tombol Orange Lembut */
        .btn-submit {
            background: linear-gradient(45deg, #ff9800, #fb8c00);
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background: linear-gradient(45deg, #fb8c00, #f57c00);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 140, 0, 0.4);
            color: white;
        }
        .btn-back {
            color: #0d47a1;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-back:hover {
            color: #fb8c00;
        }
        .input-group-text {
            background-color: #e9ecef;
            border-radius: 12px 0 0 12px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card card-custom shadow">
                <div class="card-header-custom">
                    <h3>Tambah Mobil Baru</h3>
                    <p class="mb-0 small opacity-75">Lengkapi data armada untuk disewakan</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nama Mobil</label>
                            <input type="text" name="nama_mobil" class="form-control" placeholder="Contoh: Toyota Avanza 2023" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Sewa / Hari</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_sewa" class="form-control" placeholder="500000" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kapasitas</label>
                                <input type="number" name="kapasitas" class="form-control" placeholder="Orang" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Unit</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan kondisi mobil, fasilitas, dll..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Foto Mobil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                            <div class="form-text text-muted" style="font-size: 0.75rem;">Gunakan foto berkualitas baik (JPG/PNG).</div>
                        </div>

                        <button type="submit" name="tambah" class="btn btn-submit w-100 shadow-sm">
                            Simpan & Publikasikan
                        </button>
                    </form>

                    <div class="text-center">
                        <a href="dashboard_pemilik.php" class="btn-back">← Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>