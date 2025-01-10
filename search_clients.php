<?php
include 'config.php';

// Mendapatkan kata kunci pencarian dari parameter URL
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Menyiapkan SQL untuk mencari klien berdasarkan nama, email, atau alamat
$sql_clients = "SELECT id, name, email, phone, address 
                FROM clients 
                WHERE name LIKE ? OR email LIKE ? OR address LIKE ?";

// Menyiapkan statement untuk query
$stmt = $conn->prepare($sql_clients);

// Menggunakan parameter pencarian dengan wildcard untuk LIKE
$search_param = "%" . $search_query . "%";

// Mengikat parameter ke query
$stmt->bind_param("sss", $search_param, $search_param, $search_param);

// Menjalankan query
$stmt->execute();
$result_clients = $stmt->get_result();

// Menampilkan hasil pencarian
if ($result_clients && $result_clients->num_rows > 0) {
    $no = 1;
    while ($row = $result_clients->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
        echo '<td>' . htmlspecialchars($row['address']) . '</td>';
        echo '<td>';
        echo '<a href="edit_client.php?id=' . $row['id'] . '" class="action-btn">Edit</a>';
        echo '<a href="delete_client.php?id=' . $row['id'] . '" class="action-btn" onclick="return confirm(\'Hapus klien ini?\');">Hapus</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6" style="text-align: center;">Tidak ada data klien yang cocok</td></tr>';
}

$stmt->close();
$conn->close();
?>
