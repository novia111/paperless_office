<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Pastikan ada ID laporan yang diberikan
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Hapus laporan dari database
    $delete_sql = "DELETE FROM reports WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        // Jika berhasil menghapus, alihkan kembali ke halaman laporan
        header("Location: reports.php");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus laporan'); window.location.href='reports.php';</script>";
    }
} else {
    // Jika tidak ada ID yang diberikan
    header("Location: reports.php");
    exit();
}
?>
