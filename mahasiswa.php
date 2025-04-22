<?php include 'db.php'; 

// Handle Delete
if(isset($_GET['delete'])) {
    $npm = $_GET['delete'];
    // Hapus data KRS terkait terlebih dahulu karena ada foreign key
    mysqli_query($conn, "DELETE FROM krs WHERE mahasiswa_npm='$npm'");
    // Kemudian hapus data mahasiswa
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE npm='$npm'");
    header('Location: mahasiswa.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .highlight {
            color: hotpink;
            font-weight: bold;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .welcome-section {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="container mt-5">

    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <h2 class="mb-4"><i class="fas fa-user-graduate"></i> Data Mahasiswa</h2>
        <p class="text-white mb-0">Current Date and Time (UTC): <?php echo date('Y-m-d H:i:s'); ?></p>
        <p class="text-white">User: <?php echo htmlspecialchars('daffahakim12'); ?></p>
    </div>

    <!-- Form Section -->
    <div class="card mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">Form Input Mahasiswa</h4>
            <form method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="npm" class="form-label">NPM</label>
                        <input type="text" id="npm" name="npm" class="form-control" placeholder="Masukkan NPM" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select id="jurusan" name="jurusan" class="form-select" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Sistem Operasi">Sistem Operasi</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat" rows="3" required></textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" name="simpan" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="index.php" class="btn btn-success">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Daftar Mahasiswa</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>NPM</th>
                            <th>Nama Lengkap</th>
                            <th>Jurusan</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_POST['simpan'])) {
                        $npm = mysqli_real_escape_string($conn, $_POST['npm']);
                        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
                        $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
                        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
                        
                        $check = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE npm='$npm'");
                        if(mysqli_num_rows($check) == 0) {
                            mysqli_query($conn, "INSERT INTO mahasiswa VALUES('$npm','$nama','$jurusan','$alamat')");
                            echo "<div class='alert alert-success'>Data berhasil disimpan!</div>";
                            echo "<meta http-equiv='refresh' content='1;url=mahasiswa.php'>";
                        } else {
                            echo "<div class='alert alert-danger'>NPM sudah terdaftar!</div>";
                        }
                    }

                    $data = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY npm");
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                                <td><i class='fas fa-id-card text-primary'></i> {$row['npm']}</td>
                                <td><i class='fas fa-user text-success'></i> {$row['nama']}</td>
                                <td><i class='fas fa-graduation-cap text-info'></i> {$row['jurusan']}</td>
                                <td><i class='fas fa-map-marker-alt text-warning'></i> {$row['alamat']}</td>
                                <td>
                                    <a href='mahasiswa.php?delete={$row['npm']}' class='btn btn-danger btn-sm' 
                                       onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">
                                        <i class='fas fa-trash'></i> Hapus
                                    </a>
                                </td>
                              </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-4">
        <p class="text-muted">© <?php echo date('Y'); ?> Sistem KRS Mahasiswa</p>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>