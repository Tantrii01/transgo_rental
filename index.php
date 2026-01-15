<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransGo Rental</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444;
        }

        /* Navbar Modern */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-weight: 700;
            color: #0d47a1 !important;
        }
        .navbar-brand span { color: #fb8c00; }
        .nav-link {
            font-weight: 500;
            color: #555 !important;
            text-transform: capitalize;
        }
        .nav-link:hover { color: #fb8c00 !important; }

        /* Hero / Beranda dengan Background Anda */
        #beranda {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('assets/images/BG beranda.png'); /* Mengarah ke folder Anda */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
        }
        #beranda h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 15px rgba(0,0,0,0.6);
        }
        #beranda p {
            text-shadow: 1px 1px 8px rgba(0,0,0,0.6);
        }

        /* Tentang Kami */
        .section-title {
            color: #0d47a1;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
        }
        .img-about {
            border-radius: 20px;
            box-shadow: 15px 15px 0px #e3f2fd;
            max-width: 100%;
        }

        /* Galeri */
        .grid-koleksi {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .card1 {
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .card1:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(13, 71, 161, 0.15);
        }
        .card1 img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        /* Button & Footer */
        .btn-utama {
            background: linear-gradient(45deg, #ff9800, #fb8c00);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-utama:hover {
            background: linear-gradient(45deg, #fb8c00, #f57c00);
            box-shadow: 0 5px 15px rgba(251, 140, 0, 0.3);
            color: white;
        }
        footer {
            background: #0d47a1 !important;
            padding: 20px 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#">TRANSGO<span> RENTAL</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto gap-3 align-items-center">
            <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item">
                <a class="btn-utama" href="register.php">Daftar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section id="beranda">
      <div class="container">
        <h1 class="display-3 fw-bold">Temukan teman perjalananmu</h1>
        <p class="lead fw-light">Nyaman di Perjalanan, Tenang di Tujuan.</p>
        <a href="#tentang" class="btn btn-outline-light rounded-pill px-4 mt-3">Jelajahi Kami</a>
      </div>
    </section>

    <section id="tentang" class="py-5">
      <div class="container">
        <div class="row align-items-center py-5">
          <div class="col-lg-5 mb-4 mb-lg-0">
            <img src="assets/images/logo.jpeg" alt="Logo" class="img-about">
          </div>
          <div class="col-lg-7">
            <h2 class="section-title">Tentang Kami</h2>
            <p style="text-align: justify;" class="text-muted lh-lg">
              Kami hadir untuk bikin urusan mobil jadi lebih sederhana.
              Di TransGo Rental, kami percaya perjalanan yang lancar dimulai dari pengalaman sewa yang mudah, cepat, dan transparan tanpa ribet dan tanpa biaya tersembunyi.
              <br><br>
              Kami menyediakan berbagai pilihan kendaraan untuk kebutuhan harian, liburan keluarga, perjalanan bisnis, ataupun perjalanan jarak jauh. Semua mobil dirawat secara berkala agar kamu merasa aman dan nyaman di setiap perjalanan.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section id="koleksi" class="py-5 bg-light">
      <div class="container">
        <h2 class="text-center section-title mb-5">Galeri Kami</h2>
        <div class="grid-koleksi">
          <div class="card1"><img src="assets/images/1.jpeg" alt="mobil1"></div>
          <div class="card1"><img src="assets/images/2.jpeg" alt="mobil2"></div>
          <div class="card1"><img src="assets/images/3.jpeg" alt="mobil3"></div>
          <div class="card1"><img src="assets/images/4.jpeg" alt="mobil4"></div>
          <div class="card1"><img src="assets/images/5.jpeg" alt="mobil5"></div>
          <div class="card1"><img src="assets/images/6.jpeg" alt="mobil6"></div>
        </div>
      </div>
    </section>

    <section id="kontak" class="py-5 text-center">
      <div class="container">
        <h2 class="section-title">Hubungi Kami</h2>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <p><strong>Facebook:</strong> Diosi Arisandi Arisandi</p>
                <p><strong>Telepon:</strong> +62 812 3456 7890/ +62 851 7531 5271</p>
                <p><strong>Alamat:</strong> Jl. Pangkalan No.157, Sako Baru, Kec. Sako, Palembang.</p>
                <a href="https://wa.me/6285175315271" class="btn-utama mt-3 d-inline-block">Chat WhatsApp</a>
            </div>
        </div>
      </div>
    </section>

    <footer class="text-white text-center py-3">
      <p class="mb-0">&copy; 2025 TransGo Rental. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>