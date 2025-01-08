<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Cek apakah ada ID klien yang akan dihapus
if (isset($_GET['delete_id'])) {
    $client_id = intval($_GET['delete_id']);

    // Query untuk menghapus klien berdasarkan ID
    $sql_delete = "DELETE FROM clients WHERE id = ?";
    if ($stmt = $conn->prepare($sql_delete)) {
        $stmt->bind_param("i", $client_id);
        if ($stmt->execute()) {
            header("Location: clients.php?message=Klien berhasil dihapus");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
