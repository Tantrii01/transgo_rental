<?php

session_start();

include("../config/koneksi.php");



// Pastikan hanya pemilik/admin yang bisa akses

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pemilik') {

    header("Location: ../login.php");

    exit();

}



// Ambil semua data pemesanan + info mobil + penyewa

$query = "

    SELECT s.*, m.nama_mobil, m.harga_sewa, u.nama AS nama_penyewa, s.no_wa

    FROM sewa s

    JOIN mobil m ON s.id_mobil = m.id_mobil

    JOIN users u ON s.id_user = u.id_user

    ORDER BY s.id_sewa DESC

";

$result = mysqli_query($conn, $query);

?>



<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Pemesanan - TransGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    

    <style>

        body {

            font-family: 'Poppins', sans-serif;

            background-color: #f4f7fe;

            color: #444;

        }

        .container {

            margin-top: 40px;

            margin-bottom: 40px;

        }

        .card-table {

            border: none;

            border-radius: 20px;

            background: white;

            box-shadow: 0 10px 30px rgba(0,0,0,0.05);

            overflow: hidden;

            padding: 25px;

        }

        .section-title {

            color: #0d47a1;

            font-weight: 700;

            margin-bottom: 25px;

        }

        /* Table Styling */

        .table thead {

            background-color: #0d47a1;

            color: white;

        }

        .table th {

            font-weight: 500;

            padding: 15px;

            border: none;

        }

        .table td {

            padding: 15px;

            vertical-align: middle;

            font-size: 0.9rem;

        }

        /* Status Badges */

        .badge-status {

            padding: 6px 12px;

            border-radius: 6px;

            font-weight: 500;

            font-size: 0.75rem;

        }

        .bg-pending { background-color: #fff3cd; color: #856404; }

        .bg-confirm { background-color: #d1ecf1; color: #0c5460; }

        .bg-paid { background-color: #d4edda; color: #155724; }

        .bg-done { background-color: #e2e3e5; color: #383d41; }



        /* Action Buttons */

        .btn-action {

            padding: 6px 12px;

            border-radius: 8px;

            font-size: 0.8rem;

            font-weight: 600;

            margin: 2px;

        }

        .btn-wa {

            background-color: #25d366;

            color: white;

            border: none;

        }

        .btn-wa:hover {

            background-color: #1eb954;

            color: white;

        }

        .btn-back {

            color: #888;

            text-decoration: none;

            font-size: 0.9rem;

            transition: 0.3s;

        }

        .btn-back:hover { color: #0d47a1; }

    </style>

</head>

<body>



<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="section-title m-0">Kelola Pemesanan</h3>

            <p class="text-muted small">Pantau dan konfirmasi pesanan masuk dari penyewa.</p>

        </div>

        <a href="dashboard_pemilik.php" class="btn-back">← Kembali ke Dashboard</a>

    </div>



    <div class="card-table">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr class="text-center">

                        <th>ID</th>

                        <th>Penyewa</th>

                        <th>Mobil</th>

                        <th>Periode Sewa</th>

                        <th>Total Harga</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $tanggal_hari_ini = date('Y-m-d'); ?>

                    <?php if (mysqli_num_rows($result) > 0): ?>

                        <?php while ($row = mysqli_fetch_assoc($result)): ?>

                        <tr>

                            <td class="text-center text-muted">#<?= $row['id_sewa']; ?></td>

                            <td>

                                <span class="fw-bold d-block"><?= htmlspecialchars($row['nama_penyewa']); ?></span>

                                <small class="text-primary"><?= htmlspecialchars($row['no_wa']); ?></small>

                            </td>

                            <td><?= htmlspecialchars($row['nama_mobil']); ?></td>

                            <td class="text-center">

                                <span class="small"><?= date('d/m/y', strtotime($row['tanggal_mulai'])); ?> - <?= date('d/m/y', strtotime($row['tanggal_selesai'])); ?></span>

                            </td>

                            <td class="fw-bold text-dark text-end">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>

                            <td class="text-center">

                                <?php if ($row['status'] == 'pending'): ?>

                                    <span class="badge-status bg-pending">Pending</span>

                                <?php elseif ($row['status'] == 'dikonfirmasi'): ?>

                                    <span class="badge-status bg-confirm">Dikonfirmasi</span>

                                <?php elseif ($row['status'] == 'dibayar'): ?>

                                    <span class="badge-status bg-paid">Dibayar</span>

                                <?php else: ?>

                                    <span class="badge-status bg-done">Selesai</span>

                                <?php endif; ?>

                            </td>

                            <td class="text-center">

                                <div class="d-flex flex-column flex-lg-row justify-content-center">

                                    <?php

                                    $no_hp = preg_replace('/\D/', '', $row['no_wa']);

                                    if (substr($no_hp, 0, 2) !== '62') {

                                        $no_hp = (substr($no_hp, 0, 1) === '0') ? '62' . substr($no_hp, 1) : '62' . $no_hp;

                                    }

                                    $pesan = "Halo {$row['nama_penyewa']}, pesanan Anda untuk mobil {$row['nama_mobil']} ({$row['tanggal_mulai']}) sudah kami konfirmasi.";

                                    $pesan_wa = urlencode($pesan);

                                    ?>



                                    <?php if ($row['status'] == 'pending'): ?>

                                        <a href="konfirmasi_pemesanan.php?id=<?= $row['id_sewa']; ?>" class="btn btn-action btn-success">Konfirmasi</a>

                                    <?php endif; ?>



                                    <?php if ($row['tanggal_selesai'] <= $tanggal_hari_ini && $row['status'] != 'selesai'): ?>

                                        <a href="selesai.php?id=<?= $row['id_sewa']; ?>" class="btn btn-action btn-danger">Selesai</a>

                                    <?php endif; ?>



                                    <a href="https://wa.me/<?= $no_hp; ?>?text=<?= $pesan_wa; ?>" target="_blank" class="btn btn-action btn-wa">

                                        WhatsApp

                                    </a>

                                </div>

                            </td>

                        </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data pemesanan.</td></tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>