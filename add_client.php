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

// Proses tambah klien jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah data dari form sudah ada
    if (isset($_POST['name']) && isset($_POST['email'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        // Query untuk menambahkan data ke tabel clients
        $sql_insert = "INSERT INTO clients (name, email, phone, address) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql_insert)) {
            $stmt->bind_param("ssss", $name, $email, $phone, $address);
            if ($stmt->execute()) {
                // Redirect ke clients.php setelah data berhasil ditambahkan
                header("Location: clients.php?message=Klien berhasil ditambahkan");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
            $stmt->close();
        }
    } else {
        echo "Nama dan Email klien harus diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Klien</title>
    <style>
        /* Gaya Umum */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            padding: 20px;
        }

        /* Header */
        h2 {
            text-align: center;
            color: #800000;
            font-size: 24px;
            margin-bottom: 30px;
        }

        /* Form Container */
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Wrapper untuk Label dan Input */
        .form-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group label {
            flex: 1;
            margin-right: 10px;
            font-weight: bold;
            color: #800000;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            flex: 2;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Tombol */
        button {
            width: 100%;
            background-color: #800000;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #a52a2a;
        }

        /* Tombol Kembali */
        .btn-back {
            display: block;
            text-align: center;
            margin: 20px auto;
            padding: 10px 20px;
            width: 80%;
            max-width: 200px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #a52a2a;
        }

        /* Responsif */
        @media (max-width: 768px) {
            form {
                width: 90%;
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }

            .form-group {
                flex-direction: column;
                align-items: stretch;
            }

            .form-group label {
                margin-bottom: 5px;
            }

            .btn-back {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h2>Tambah Klien</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Nama Klien:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email Klien:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Telepon:</label>
            <input type="text" id="phone" name="phone">
        </div>

        <div class="form-group">
            <label for="address">Alamat:</label>
            <textarea id="address" name="address" rows="3"></textarea>
        </div>

        <button type="submit">Tambah Klien</button>
    </form>

    <!-- Tombol Kembali -->
    <a href="clients.php" class="btn-back">Kembali ke Daftar Klien</a>
</body>
</html>
