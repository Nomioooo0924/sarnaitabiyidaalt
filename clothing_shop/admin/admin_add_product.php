<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
include __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $desc, $price, $image, $category);
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
    Үнэ: <input type="number" name="price"><br>
    Зургийн нэр (assets дотор): <input type="text" name="image"><br>
    Ангилал: 
    <select name="category">
        <option>Цамц</option>
        <option>Өмд</option>
        <option>Дотуур хувцас</option>
        <option>Гутал</option>
        <option>Гадуур хувцас</option>
        <option>Малгай</option>
        <option>Даашинз</option>
        <option>Пиджак</option>
        <option>Спорт хувцас</option>
        <option>Унтлагын хувцас</option>
    </select><br>
    <button type="submit">Нэмэх</button>
</form>
