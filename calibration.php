<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Mengambil data alat kalibrasi
$sql_tools = "SELECT id, tool_name, calibration_status, last_calibrated FROM calibration_tools";
$result_tools = $conn->query($sql_tools);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alat Kalibrasi</title>
    <style>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            text-align: left;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #800000;
            color: white;
        }
        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            background-color: #800000;
            border-radius: 5px;
            margin-right: 5px;
        }
        .action-btn:hover {
            background-color: #a52a2a;
        }
        .add-btn {
            display: inline-block;
            width: fit-content;
            padding: 10px 15px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        .add-btn:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <header>
        <h1>Novia Kalibrasi</h1>
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

    <a href="add_tool.php" class="add-btn">Tambah Alat Kalibrasi</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Status Kalibrasi</th>
                <th>Terakhir Dikalibrasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_tools && $result_tools->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result_tools->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['tool_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['calibration_status']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_calibrated']); ?></td>
                        <td>
                            <a href="edit_tool.php?id=<?php echo $row['id']; ?>" class="action-btn">Edit</a>
                            <a href="delete_tool.php?id=<?php echo $row['id']; ?>" class="action-btn" onclick="return confirm('Hapus alat ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data alat kalibrasi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
