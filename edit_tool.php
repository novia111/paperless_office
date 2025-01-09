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
$error = "";

// Ambil data alat berdasarkan ID
$sql = "SELECT * FROM calibration_tools WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tool_id);
$stmt->execute();
$result = $stmt->get_result();
$tool = $result->fetch_assoc();

if (!$tool) {
    header("Location: calibration.php");
    exit();
}

// Proses penyimpanan perubahan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_name = $_POST['tool_name'];
    $calibration_status = $_POST['calibration_status'];
    $last_calibrated = $_POST['last_calibrated'];

    if (empty($tool_name) || empty($calibration_status) || empty($last_calibrated)) {
        $error = "Semua kolom wajib diisi!";
    } else {
        $sql_update = "UPDATE calibration_tools SET tool_name = ?, calibration_status = ?, last_calibrated = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $tool_name, $calibration_status, $last_calibrated, $tool_id);
        if ($stmt_update->execute()) {
            header("Location: calibration.php");
            exit();
        } else {
            $error = "Gagal mengupdate data. Silakan coba lagi.";
        }
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
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #800000;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        button {
            background-color: #800000;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #a52a2a;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .back-btn {
            text-decoration: none;
            background-color: #800000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Alat Kalibrasi</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="tool_name">Nama Alat</label>
            <input type="text" id="tool_name" name="tool_name" value="<?php echo htmlspecialchars($tool['tool_name']); ?>" required>

            <label for="calibration_status">Status Kalibrasi</label>
            <select id="calibration_status" name="calibration_status" required>
                <option value="Terkalibrasi" <?php echo $tool['calibration_status'] === 'Terkalibrasi' ? 'selected' : ''; ?>>Terkalibrasi</option>
                <option value="Belum Terkalibrasi" <?php echo $tool['calibration_status'] === 'Belum Terkalibrasi' ? 'selected' : ''; ?>>Belum Terkalibrasi</option>
            </select>

            <label for="last_calibrated">Terakhir Dikalibrasi</label>
            <input type="date" id="last_calibrated" name="last_calibrated" value="<?php echo htmlspecialchars($tool['last_calibrated']); ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="calibration.php" class="back-btn">Kembali</a>
    </div>
</body>
</html>
