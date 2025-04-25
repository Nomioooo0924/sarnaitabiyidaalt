<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

include '../includes/db.php';

// Бараа мэдээллийг авч засах
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $res = $conn->query("SELECT * FROM products WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $category = $row['category'];
        $image = $row['image'];
    } else {
        echo "Бараа олдсонгүй.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    // Ангилал болон бусад утгуудыг шалгах
    $category = isset($_POST['category']) && $_POST['category'] != '' ? $_POST['category'] : $category;  // Хэрэв `$_POST['category']` хоосон бол өмнөх утга хадгалагдана

    // Барааг шинэчилж оруулах
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, category = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $name, $desc, $price, $image, $category, $id);
    if ($stmt->execute()) {
        echo "✅ Амжилттай засагдлаа! ";
    } else {
        echo "Алдаа: " . $conn->error;
    }
}
?>

<a href="admin_panel.php" style="text-decoration:none; color:#333;">
    <i class="fas fa-arrow-left"></i>
</a>
<h2>Засах бараа: <?php echo $name; ?></h2>
<form method="post" class="edit-form">
    <label for="">Нэр: </label>
    <input type="text" name="name" value="<?php echo $name; ?>"><br><br>
    <label for="">Тайлбар:</label>
    <input type="text" name="description" value="<?php echo $description; ?>"><br><br>
    <label for="">Үнэ:</label> 
    <input type="number" name="price" step="0.01" value="<?php echo $price; ?>"><br><br>
    <label for="">Зургийн нэр (assets дотор):</label> 
    <input type="text" name="image" value="<?php echo $image; ?>"><br><br>
    <label for="">Ангилал:</label> 
    <select name="category">
        <option value="Цамц" <?= $category == 'Цамц' ? 'selected' : 'Цамц' ?>>Цамц</option>
        <option value="Өмд" <?= $category == 'Өмд' ? 'selected' : '' ?>>Өмд</option>
        <option value="Дотуур хувцас" <?= $category == 'Дотуур хувцас' ? 'selected' : '' ?>>Дотуур хувцас</option>
        <option value="Гутал" <?= $category == 'Гутал' ? 'selected' : '' ?>>Гутал</option>
        <option value="Гадуур хувцас" <?= $category == 'Гадуур хувцас' ? 'selected' : '' ?>>Гадуур хувцас</option>
        <option value="Даашинз" <?= $category == 'Даашинз' ? 'selected' : '' ?>>Даашинз</option>
        <option value="Пиджак" <?= $category == 'Пиджак' ? 'selected' : '' ?>>Пиджак</option>
        <option value="Спорт хувцас" <?= $category == 'Спорт хувцас' ? 'selected' : '' ?>>Спорт хувцас</option>
        <option value="Унтлагын хувцас" <?= $category == 'Унтлагын хувцас' ? 'selected' : '' ?>>Унтлагын хувцас</option>
    </select><br><br>
    <button type="submit">Шинэчлэх</button>
</form>


<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
