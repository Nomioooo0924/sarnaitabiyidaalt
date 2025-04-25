<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
include '../includes/db.php';

// Бараануудыг харах
$res = $conn->query("SELECT * FROM products");
echo "<h2>Бараа удирдлага</h2>";
echo "<table border='1' cellpadding='10'>
        <tr><th>Нэр</th><th>Үнэ</th><th>Ангилал</th><th>Үйлдэл</th></tr>";

while ($row = $res->fetch_assoc()) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['price']}₮</td>
            <td>{$row['category']}</td>
            <td>
                <a href='edit_product.php?id={$row['id']}'><i class='fas fa-edit'></i></a> |
                <a href='delete_product.php?id={$row['id']}'><i class='fas fa-trash-alt'></i></a>
            </td>
          </tr>";
}

echo "</table>";
?>
<a href="admin_panel.php">Буцах</a>
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
