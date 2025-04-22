<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_mahasiswa";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}
?>