<?php
// Di dalam file PHP sebelum HTML dimulai
if (isset($_GET['message'])) {
    echo '<div style="text-align:center; padding:10px; background-color:#d4edda; color:#155724; margin-bottom:20px; border:1px solid #c3e6cb; border-radius:5px;">' . htmlspecialchars($_GET['message']) . '</div>';
}

if (isset($_GET['error'])) {
    echo '<div style="text-align:center; padding:10px; background-color:#f8d7da; color:#721c24; margin-bottom:20px; border:1px solid #f5c6cb; border-radius:5px;">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Hapus data jika ada permintaan DELETE
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql_delete = "DELETE FROM clients WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql_delete)) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            header("Location: clients.php?message=Klien berhasil dihapus");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
}

// Ambil data klien dari database
$sql = "SELECT * FROM clients ORDER BY name";
$result = $conn->query($sql);
$clients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klien</title>
    <style>
        /* Gaya Umum */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header, Nav, Footer */
        header, nav, footer {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        nav a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: auto;
        }

        /* Kontainer */
        .container {
            padding: 20px;
            flex: 1;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: center;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        table th {
            background-color: #800000;
            color: white;
        }

        /* Tombol */
        .btn-add, .btn-back, .btn-edit, .btn-delete {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 5px;
            color: white;
            font-weight: bold;
        }

        .btn-add {
            background-color: #800000; /* Hijau */
        }

        .btn-add:hover {
            background-color: #a52a2a9;
        }

        .btn-edit {
            background-color: #800000; /* Merah maroon */
        }

        .btn-edit:hover {
            background-color: #a52a2a;
        }

        .btn-delete {
            background-color: #b22222; /* Merah lebih terang */
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin: 30px auto;
            width: 200px;
            background-color: #800000;
        }

        .btn-back:hover {
            background-color: #a52a2a;
        }

        /* Dropdown */
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

        /* Responsif */
        @media (max-width: 768px) {
            table, .btn-add, .btn-back, .btn-edit, .btn-delete {
                width: 100%;
                margin: 5px 0;
            }
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
        <h2>Daftar Klien</h2>
        <a href="add_client.php" class="btn-add">Tambah Klien</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Klien</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                    <tr>
                        <td colspan="6">Belum ada data klien.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?php echo $client['id']; ?></td>
                            <td><?php echo htmlspecialchars($client['name']); ?></td>
                            <td><?php echo htmlspecialchars($client['email']); ?></td>
                            <td><?php echo htmlspecialchars($client['phone']); ?></td>
                            <td><?php echo htmlspecialchars($client['address']); ?></td>
                            <td>
                                <a href="edit_client.php?id=<?php echo $client['id']; ?>" class="btn-edit">Edit</a>
                                <a href="clients.php?delete_id=<?php echo $client['id']; ?>" class="btn-delete" onclick="return confirm('Hapus klien ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Tombol Kembali ke Dashboard -->
        <a href="dashboard.php" class="btn-back">Kembali ke Dashboard</a>
    </div>
    <footer>
        <p>&copy; 2025 Novia Kalibrasi</p>
    </footer>
</body>
</html>
