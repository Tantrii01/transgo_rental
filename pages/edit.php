<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pemilik') {
    header("Location: ../login.php");
    exit();
}

$id_mobil = $_GET['id'];
$id_pemilik = $_SESSION['id_user'];

// Ambil data mobil lama
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil = '$id_mobil' AND id_pemilik = '$id_pemilik'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: dashboard_pemilik.php");
    exit();
}

// Proses Update
if (isset($_POST['update'])) {
    $nama_mobil = $_POST['nama_mobil'];
    $harga_sewa = $_POST['harga_sewa'];
    $kapasitas = $_POST['kapasitas'];
    $status = $_POST['status'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "UPDATE mobil SET 
            nama_mobil = '$nama_mobil', 
            harga_sewa = '$harga_sewa', 
            kapasitas = '$kapasitas', 
            status = '$status',
            deskripsi = '$deskripsi'
            WHERE id_mobil = '$id_mobil'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data mobil berhasil diperbarui!'); window.location='dashboard_pemilik.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil - TransGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7fe; }
        .card-edit { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header-edit { background: #0d47a1; color: white; border-radius: 20px 20px 0 0; padding: 20px; }
        .btn-save { background: linear-gradient(45deg, #ff9800, #fb8c00); border: none; color: white; font-weight: 600; padding: 12px; border-radius: 12px; transition: 0.3s; }
        .btn-save:hover { background: linear-gradient(45deg, #fb8c00, #f57c00); transform: translateY(-2px); color: white; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card card-edit">
                <div class="header-edit text-center">
                    <h4 class="mb-0">Edit Detail Mobil</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Mobil</label>
                            <input type="text" name="nama_mobil" class="form-control" value="<?= $data['nama_mobil']; ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga Sewa / Hari</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_sewa" class="form-control" value="<?= $data['harga_sewa']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kapasitas (Orang)</label>
                                <input type="number" name="kapasitas" class="form-control" value="<?= $data['kapasitas']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Armada</label>
                            <select name="status" class="form-select">
                                <option value="tersedia" <?= $data['status'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                                <option value="disewa" <?= $data['status'] == 'disewa' ? 'selected' : ''; ?>>Sedang Disewa</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Mobil</label>
                            <textarea name="deskripsi" class="form-control" rows="4"><?= $data['deskripsi']; ?></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="update" class="btn btn-save w-100">Simpan Perubahan</button>
                            <a href="dashboard_pemilik.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">Batal & Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>