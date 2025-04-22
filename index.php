<!DOCTYPE html>
<html>
<head>
    <title>Home - KRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --border-radius: 10px;
            --card-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .stats-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
            height: 100%;
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .menu-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            background: #f8f9fa;
        }

        .recent-activity {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            margin-top: 2rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #343a40;
            color: white;
            border: none;
        }

        .table td {
            vertical-align: middle;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 1.5rem 0;
            margin-top: 3rem;
            border-radius: var(--border-radius);
        }

        .datetime-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            display: inline-block;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <h1><i class="fas fa-university"></i> Sistem KRS Mahasiswa</h1>
        <p class="lead mb-3">Selamat datang di Sistem Informasi KRS</p>
        <div class="user-info">
            <i class="fas fa-user"></i> User: <?php echo htmlspecialchars('daffahakim12'); ?>
        </div>
        <div class="datetime-box">
            <i class="far fa-clock"></i> <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <!-- Statistics Section -->
    <?php
    include 'db.php';
    $mhs_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM mahasiswa"))[0];
    $mk_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM matakuliah"))[0];
    $krs_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM krs"))[0];
    ?>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card text-center">
                <div class="icon-circle bg-primary bg-opacity-10">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>
                <h3><?php echo number_format($mhs_count); ?></h3>
                <p class="text-muted mb-0">Total Mahasiswa</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card text-center">
                <div class="icon-circle bg-success bg-opacity-10">
                    <i class="fas fa-book fa-3x text-success"></i>
                </div>
                <h3><?php echo number_format($mk_count); ?></h3>
                <p class="text-muted mb-0">Total Mata Kuliah</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card text-center">
                <div class="icon-circle bg-info bg-opacity-10">
                    <i class="fas fa-clipboard-list fa-3x text-info"></i>
                </div>
                <h3><?php echo number_format($krs_count); ?></h3>
                <p class="text-muted mb-0">Total KRS</p>
            </div>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="menu-card text-center">
                <div class="icon-circle bg-primary bg-opacity-10">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>
                <h4>Data Mahasiswa</h4>
                <p class="text-muted">Kelola data mahasiswa termasuk NPM, nama, jurusan, dan alamat.</p>
                <a href="mahasiswa.php" class="btn btn-primary w-100">
                    <i class="fas fa-arrow-right"></i> Akses Data Mahasiswa
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="menu-card text-center">
                <div class="icon-circle bg-success bg-opacity-10">
                    <i class="fas fa-book fa-3x text-success"></i>
                </div>
                <h4>Data Mata Kuliah</h4>
                <p class="text-muted">Kelola data mata kuliah termasuk kode, nama, dan jumlah SKS.</p>
                <a href="matakuliah.php" class="btn btn-success w-100">
                    <i class="fas fa-arrow-right"></i> Akses Data Mata Kuliah
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="menu-card text-center">
                <div class="icon-circle bg-info bg-opacity-10">
                    <i class="fas fa-clipboard-list fa-3x text-info"></i>
                </div>
                <h4>Input & Tampil KRS</h4>
                <p class="text-muted">Kelola Kartu Rencana Studi (KRS) mahasiswa.</p>
                <a href="krs.php" class="btn btn-info w-100 text-white">
                    <i class="fas fa-arrow-right"></i> Akses Data KRS
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
        <h3 class="mb-4"><i class="fas fa-history"></i> Aktivitas Terakhir KRS</h3>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $recent_krs = mysqli_query($conn, "
                        SELECT m.nama AS nama_mhs, mk.nama AS nama_mk, mk.jumlah_sks, k.id
                        FROM krs k
                        JOIN mahasiswa m ON k.mahasiswa_npm = m.npm
                        JOIN matakuliah mk ON k.matakuliah_kodemk = mk.kodemk
                        ORDER BY k.id DESC LIMIT 5
                    ");

                    while ($row = mysqli_fetch_assoc($recent_krs)) {
                        echo "<tr>
                                <td><i class='fas fa-user text-primary'></i> {$row['nama_mhs']}</td>
                                <td><i class='fas fa-book text-success'></i> {$row['nama_mk']}</td>
                                <td><i class='fas fa-graduation-cap text-info'></i> {$row['jumlah_sks']} SKS</td>
                                <td><i class='far fa-clock text-secondary'></i> Baru saja</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <span>© <?php echo date('Y'); ?> Sistem KRS Mahasiswa. Developed with <i class="fas fa-heart text-danger"></i> by <?php echo htmlspecialchars('daffahakim12'); ?></span>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>