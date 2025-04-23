<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image']; // одоогоор зургийн нэр л авна

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $desc, $price, $image);
    if ($stmt->execute()) {
        echo "✅ Амжилттай нэмэгдлээ! <a href='admin_panel.php'>Буцах</a>";
    } else {
        echo "Алдаа: " . $conn->error;
    }
}
?>

<h2>➕ Шинэ бараа нэмэх</h2>
<form method="post">
    Нэр: <input type="text" name="name"><br>
    Тайлбар: <input type="text" name="description"><br>
    Үнэ: <input type="number" name="price" step="0.01"><br>
    Зургийн нэр (assets дотор): <input type="text" name="image"><br>
    <button type="submit">Нэмэх</button>
</form>
