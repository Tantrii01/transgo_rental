<?php
include("config/koneksi.php");
session_start();

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Ambil data user berdasarkan email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Login berhasil, set session
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // Redirect sesuai role
            if ($user['role'] == 'penyewa') {
                header("Location: pages/dashboard_penyewa.php");
                exit;
            } elseif ($user['role'] == 'pemilik') {
                header("Location: pages/dashboard_pemilik.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sewa Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Gradasi Biru Lembut (Sama dengan Register) */
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            background-color: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 100%;
            padding: 40px;
        }
        .header-title {
            color: #0d47a1; /* Biru Tua */
            font-weight: 600;
        }
        .form-control {
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
        .register-link {
            color: #fb8c00;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link:hover {
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
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
            <div class="login-card">
                <div class="text-center mb-4">
                    <h3 class="header-title">Selamat Datang</h3>
                    <p class="text-muted small">Silakan login untuk mengakses akun Anda</p>
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="********" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0 text-muted small">Belum punya akun? 
                        <a href="register.php" class="register-link">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>