<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Periksa apakah ada ID untuk diedit
if (isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);

    // Ambil data alat berdasarkan ID
    $sql = "SELECT * FROM calibration_tools WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tool = $result->fetch_assoc();
        $stmt->close();
    }

    // Periksa apakah data ditemukan
    if (!$tool) {
        header("Location: calibration.php?error=Alat tidak ditemukan");
        exit();
    }
} else {
    header("Location: calibration.php?error=ID tidak valid");
    exit();
}

// Update data alat jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $status = $_POST['status'];
    $last_calibration = $_POST['last_calibration'];

    $sql_update = "UPDATE calibration_tools SET name = ?, status = ?, last_calibration = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql_update)) {
        $stmt->bind_param("sssi", $name, $status, $last_calibration, $edit_id);
        if ($stmt->execute()) {
            header("Location: calibration.php?message=Data berhasil diperbarui");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alat Kalibrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <h2>Edit Alat Kalibrasi</h2>
    <form method="POST">
        <label for="name">Nama Alat</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($tool['name']); ?>" required>

        <label for="status">Status</label>
        <select id="status" name="status">
            <option value="Terkalibrasi">Terkalibrasi</option>
            <option value="Butuh Kalibrasi">Butuh Kalibrasi</option>
        </select>
        
        <label for="last_calibration">Kalibrasi Terakhir</label>
        <input type="date" name="last_calibration" id="last_calibration" value="<?php echo htmlspecialchars($tool['last_calibration']); ?>" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
