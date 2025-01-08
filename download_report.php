<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if (isset($_GET['id'])) {
    $report_id = intval($_GET['id']);

    // Ambil informasi laporan dari database
    $sql = "SELECT * FROM reports WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $report_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $report = $result->fetch_assoc();
            $file_path = 'uploads/reports/' . $report['file_name'];

            if (file_exists($file_path)) {
                // Header untuk mengunduh file
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit();
            } else {
                echo "File laporan tidak ditemukan.";
            }
        } else {
            echo "Laporan tidak ditemukan.";
        }
        $stmt->close();
    }
} else {
    echo "ID laporan tidak valid.";
}
?>
