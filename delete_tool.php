<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Menghapus alat kalibrasi berdasarkan ID
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus data alat kalibrasi berdasarkan ID
    $sql_delete = "DELETE FROM calibration_tools WHERE id = '$delete_id'";

    if ($conn->query($sql_delete) === TRUE) {
        header("Location: calibration.php"); // Redirect setelah berhasil menghapus alat
        exit();
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
}
?>
