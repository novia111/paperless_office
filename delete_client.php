<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Memeriksa apakah ada ID yang diberikan di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data klien berdasarkan ID
    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter ID sebagai integer

    // Menjalankan query
    if ($stmt->execute()) {
        // Jika berhasil menghapus data, redirect ke halaman clients.php
        header("Location: clients.php?status=success");
        exit();
    } else {
        // Jika gagal menghapus data, menampilkan pesan error
        echo "Error: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
} else {
    // Jika ID tidak ditemukan di URL
    echo "ID tidak ditemukan!";
}

// Menutup koneksi
$conn->close();
?>
