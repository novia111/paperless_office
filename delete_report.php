<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Mengambil nama file laporan
    $sql = "SELECT file_name FROM reports WHERE id = $id";
    $result = $conn->query($sql);
    $report = $result->fetch_assoc();

    if ($report) {
        // Menghapus file
        $file_path = 'uploads/' . $report['file_name'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Menghapus data laporan dari database
        $sql = "DELETE FROM reports WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: reports.php");
            exit();
        }
    }
}

header("Location: reports.php");
exit();
