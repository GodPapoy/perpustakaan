<?php
// Konfigurasi koneksi database
$host     = "localhost";
$user     = "root";
$password = "";            // XAMPP default kosong
$database = "perpustakaan";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
