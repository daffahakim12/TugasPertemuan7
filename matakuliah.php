<?php include 'db.php'; 

// Handle Delete
if(isset($_GET['delete'])) {
    $kodemk = $_GET['delete'];
    // Hapus data KRS terkait terlebih dahulu
    mysqli_query($conn, "DELETE FROM krs WHERE matakuliah_kodemk='$kodemk'");
    // Kemudian hapus data mata kuliah
    mysqli_query($conn, "DELETE FROM matakuliah WHERE kodemk='$kodemk'");
    header('Location: matakuliah.php');
    exit;
}

// Handle Insert
if(isset($_POST['simpan'])) {
    $kodemk = mysqli_real_escape_string($conn, $_POST['kodemk']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jumlah_sks = (int)$_POST['jumlah_sks'];
    
    // Validasi input
    if(empty($kodemk) || empty($nama) || $jumlah_sks <= 0) {
        $error = "Semua field harus diisi dengan benar!";
    } else {
        // Cek duplikasi kode mata kuliah
        $check = mysqli_query($conn, "SELECT * FROM matakuliah WHERE kodemk='$kodemk'");
        if(mysqli_num_rows($check) == 0) {
            // Query insert
            $query = "INSERT INTO matakuliah (kodemk, nama, jumlah_sks) VALUES ('$kodemk', '$nama', $jumlah_sks)";
            if(mysqli_query($conn, $query)) {
                $success = "Data berhasil disimpan!";
                // Redirect setelah 1 detik
                header("refresh:1;url=matakuliah.php");
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        } else {
            $error = "Kode MK '$kodemk' sudah terdaftar!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Mata Kuliah</title>
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
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body class="container mt-5">

    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <h2 class="mb-4"><i class="fas fa-book"></i> Data Mata Kuliah</h2>
        <p class="text-white mb-0">Current Date and Time (UTC): <?php echo date('Y-m-d H:i:s'); ?></p>
        <p class="text-white">User: <?php echo htmlspecialchars('daffahakim12'); ?></p>
    </div>

    <!-- Display Messages -->
    <?php if(isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if(isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Form Section -->
    <div class="card mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">Form Input Mata Kuliah</h4>
            <form method="post" action="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="kodemk" class="form-label">Kode Mata Kuliah</label>
                        <input type="text" id="kodemk" name="kodemk" class="form-control" 
                               placeholder="Masukkan Kode MK" maxlength="6" required
                               value="<?php echo isset($_POST['kodemk']) ? htmlspecialchars($_POST['kodemk']) : ''; ?>">
                        <small class="text-muted">Maksimal 6 karakter</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nama" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" id="nama" name="nama" class="form-control" 
                               placeholder="Masukkan Nama MK" maxlength="50" required
                               value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="jumlah_sks" class="form-label">Jumlah SKS</label>
                        <input type="number" id="jumlah_sks" name="jumlah_sks" class="form-control" 
                               placeholder="Masukkan SKS" min="1" max="6" required
                               value="<?php echo isset($_POST['jumlah_sks']) ? htmlspecialchars($_POST['jumlah_sks']) : ''; ?>">
                        <small class="text-muted">Antara 1-6 SKS</small>
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
            <h4 class="card-title mb-4">Daftar Mata Kuliah</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM matakuliah ORDER BY kodemk");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td><i class='fas fa-hashtag text-primary'></i> {$row['kodemk']}</td>
                                <td><i class='fas fa-book text-success'></i> {$row['nama']}</td>
                                <td><i class='fas fa-graduation-cap text-info'></i> {$row['jumlah_sks']} SKS</td>
                                <td>
                                    <a href='matakuliah.php?delete={$row['kodemk']}' class='btn btn-danger btn-sm'
                                       onclick=\"return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')\">
                                        <i class='fas fa-trash'></i> Hapus
                                    </a>
                                </td>
                              </tr>";
                        $no++;
                    }
                    if (mysqli_num_rows($data) == 0) {
                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
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