<?php
include("config/koneksi.php");

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO users (nama, email, password, role) VALUES ('$nama','$email','$hashed','$role')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sewa Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Gradasi Biru Lembut untuk background */
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
        }
        .card-header {
            background: transparent;
            border: none;
            padding-top: 30px;
        }
        .header-title {
            color: #0d47a1; /* Biru Tua */
            font-weight: 600;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: 0 0 10px rgba(13, 71, 161, 0.1);
            border-color: #0d47a1;
        }
        /* Tombol Orange Lembut */
        .btn-primary {
            background: linear-gradient(45deg, #ff9800, #fb8c00);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #fb8c00, #f57c00);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 140, 0, 0.4);
        }
        /* Link Warna Orange */
        .login-link {
            color: #fb8c00;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link:hover {
            color: #0d47a1;
            text-decoration: underline;
        }
        label {
            font-weight: 500;
            color: #455a64;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-5 col-xl-4">
            <div class="card my-5">
                <div class="card-header text-center">
                    <h3 class="header-title">Daftar Akun</h3>
                    <p class="text-muted small">Bergabung dengan Sewa Mobil Kami</p>
                </div>
                <div class="card-body px-4 pb-5">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="********" required>
                        </div>
                        <div class="mb-4">
                            <label>Daftar Sebagai</label>
                            <select name="role" class="form-select" required>
                                <option value="penyewa">Penyewa</option>
                            </select>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary w-100">Daftar Sekarang</button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0 text-muted small">Sudah punya akun? 
                            <a href="login.php" class="login-link">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>