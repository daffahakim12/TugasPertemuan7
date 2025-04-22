<?php 
include 'db.php';

// Proses Hapus Data
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if(hapusData('krs', 'id', $id)) {
        echo "<script>alert('Data KRS berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data KRS!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>KRS Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .highlight {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body class="container mt-5" style="background-color: #f8f9fa;">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Form KRS</h2>
        </div>
        <div class="card-body">
            <form method="post" class="mb-0">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                            <select name="npm" class="form-select" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                <?php
                                $mhs = mysqli_query($conn, "SELECT * FROM mahasiswa");
                                while ($row = mysqli_fetch_assoc($mhs)) {
                                    echo "<option value='{$row['npm']}'>{$row['npm']} - {$row['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <select name="kodemk" class="form-select" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                                <?php
                                $mk = mysqli_query($conn, "SELECT * FROM matakuliah");
                                while ($row = mysqli_fetch_assoc($mk)) {
                                    echo "<option value='{$row['kodemk']}'>{$row['kodemk']} - {$row['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="simpan" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="index.php" class="btn btn-success">
                        <i class="fas fa-home me-1"></i> Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container">
        <h3 class="mb-4"><i class="fas fa-list me-2"></i>Data KRS</h3>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Mata Kuliah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_POST['simpan'])) {
                    mysqli_query($conn, "INSERT INTO krs (mahasiswa_npm, matakuliah_kodemk) 
                        VALUES('".mysqli_real_escape_string($conn, $_POST['npm'])."', 
                               '".mysqli_real_escape_string($conn, $_POST['kodemk'])."')");
                    echo "<script>window.location='krs.php';</script>";
                }

                $no = 1;
                $data = mysqli_query($conn, "SELECT k.id, m.nama AS nama_mhs, mk.nama AS nama_mk, mk.jumlah_sks
                                           FROM krs k
                                           JOIN mahasiswa m ON k.mahasiswa_npm = m.npm
                                           JOIN matakuliah mk ON k.matakuliah_kodemk = mk.kodemk");

                while ($row = mysqli_fetch_assoc($data)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama_mhs']}</td>
                            <td>{$row['nama_mk']}</td>
                            <td><span class='highlight'>{$row['nama_mhs']}</span> Mengambil Mata Kuliah 
                                <span class='highlight'>{$row['nama_mk']} ({$row['jumlah_sks']} SKS)</span></td>
                            <td>
                                <a href='?hapus={$row['id']}' class='btn btn-danger btn-sm' 
                                   onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                   <i class='fas fa-trash'></i>
                                </a>
                            </td>
                          </tr>";
                    $no++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>