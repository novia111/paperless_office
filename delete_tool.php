<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Periksa apakah parameter `id` ada
if (!isset($_GET['id'])) {
    header("Location: calibration.php");
    exit();
}

$tool_id = $_GET['id'];

// Proses penghapusan data
$sql = "DELETE FROM calibration_tools WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tool_id);

if ($stmt->execute()) {
    // Jika berhasil, kembali ke halaman daftar alat
    header("Location: calibration.php?message=success");
    exit();
} else {
    // Jika gagal, kembali dengan pesan kesalahan
    header("Location: calibration.php?message=error");
    exit();
}
?>
