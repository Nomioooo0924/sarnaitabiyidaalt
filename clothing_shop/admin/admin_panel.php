<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

include 'includes/db.php';

echo "<h2>👩‍💼 Админ удирдлага</h2>";
echo "<a href='admin_add_product.php'>➕ Шинэ бараа нэмэх</a><br><br>";

$res = $conn->query("SELECT * FROM products");
while ($row = $res->fetch_assoc()) {
    echo "{$row['name']} - {$row['price']}₮ <br>";
}
