<?php
$host = 'localhost'; // Nama host, biasanya 'localhost'
$user = 'root'; // Username database
$password = ''; // Password database, kosong jika tidak ada
$dbname = 'paperless_office'; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>
