<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Ambil data alat kalibrasi dari database
$sql = "SELECT * FROM calibration_tools";
$result = $conn->query($sql);
$calibration_tools = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $calibration_tools[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alat Kalibrasi</title>
    <style>
        /* Gaya dasar */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            text-align: center;
            position: relative;
        }

        /* Dropdown button */
        .dropdown {
            position: absolute;
            top: 15px;
            right: 20px;
            cursor: pointer;
            font-size: 30px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #800000;
            min-width: 160px;
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #a52a2a;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Kontainer */
        .container {
            padding: 20px;
            flex: 1;
        }

        /* Tombol */
        .btn-add, .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }

        .btn-add:hover, .btn-back:hover {
            background-color: #a52a2a;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #800000;
            color: white;
        }

        /* Tombol dalam tabel */
        .btn-add, .btn-edit, .btn-delete {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 5px;
        }

        .btn-add {
            background-color: #800000;
            color: white;
        }

        .btn-add:hover {
            background-color: #800000;
        }

        .btn-edit {
            background-color: #800000;
            color: white;
        }

        .btn-edit:hover {
            background-color: #a52a2a;
        }

        .btn-delete {
            background-color: #800000;
            color: white;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        /* Tombol Kembali ke Dashboard */
        .btn-back {
            display: block;
            text-align: center;
            margin: 30px auto;
            width: 200px;
            background-color: #800000;
            color: white;
        }

        .btn-back:hover {
            background-color: #a52a2a;
        }

        /* Footer */
        footer {
            background-color: #800000;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto; /* Push footer to the bottom */
        }
    </style>
</head>
<body>
    <header>
        <h1>Novia Kalibrasi</h1>
        <!-- Dropdown button -->
        <div class="dropdown">
            &#x22EE; <!-- Unicode untuk titik tiga -->
            <div class="dropdown-content">
                <a href="dashboard.php">Dashboard</a>
                <a href="calibration.php">Alat Kalibrasi</a>
                <a href="schedule.php">Jadwal Kalibrasi</a>
                <a href="clients.php">Klien</a>
                <a href="reports.php">Laporan</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>
    <div class="container">
        <h2>Daftar Alat Kalibrasi</h2>
        <a href="add_tool.php" class="btn-add">Tambah Alat</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Alat</th>
                    <th>Status</th>
                    <th>Kalibrasi Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($calibration_tools as $tool): ?>
                    <tr>
                        <td><?php echo $tool['id']; ?></td>
                        <td><?php echo htmlspecialchars($tool['name']); ?></td>
                        <td><?php echo htmlspecialchars($tool['status']); ?></td>
                        <td><?php echo htmlspecialchars($tool['last_calibration']); ?></td>
                        <td>
                            <a href="edit_tool.php?id=<?php echo $tool['id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_tool.php?delete_id=<?php echo $tool['id']; ?>" class="btn-delete" onclick="return confirm('Hapus alat ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn-back">Kembali ke Dashboard</a>
    </div>
</body>
</html>
