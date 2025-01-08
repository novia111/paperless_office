<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Menambahkan alat kalibrasi ke database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $status = $_POST['status'];
    $last_calibration = $_POST['last_calibration'];

    $sql_insert = "INSERT INTO calibration_tools (name, status, last_calibration) 
                   VALUES ('$name', '$status', '$last_calibration')";

    if ($conn->query($sql_insert) === TRUE) {
        header("Location: calibration.php"); // Redirect setelah berhasil menambahkan alat
        exit();
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alat Kalibrasi</title>
    <style>
        /* Gaya CSS untuk form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
        }

        .container {
            padding: 20px;
        }

        h2 {
            color: #800000;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        select {
            cursor: pointer;
        }

        .btn-submit {
            display: inline-block;
            padding: 10px 20px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Alat Kalibrasi</h2>
        <form action="add_tool.php" method="POST">
            <label for="name">Nama Alat:</label>
            <input type="text" name="name" required><br><br>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="Terkalibrasi">Terkalibrasi</option>
                <option value="Butuh Kalibrasi">Butuh kalibrasi</option>
            </select><br><br>

            <label for="last_calibration">Kalibrasi Terakhir:</label>
            <input type="date" name="last_calibration" required><br><br>

            <button type="submit" class="btn-submit">Tambah Alat</button>
        </form>
    </div>
</body>
</html>
