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
    $category = isset($_POST['category']) && $_POST['category'] != '' ? $_POST['category'] : $category;

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, category = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $name, $desc, $price, $image, $category, $id);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Амжилттай засагдлаа!</p>";
    } else {
        echo "<p style='color: red;'>Алдаа: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Бараа засах</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        form.edit-form {
            max-width: 500px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1f8dd6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #156ba3;
        }

        a {
            text-decoration: none;
            color: #1f1f1f;
            margin-bottom: 20px;
            display: inline-block;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<a href="admin_panel.php"><i class="fas fa-arrow-left"></i> Буцах</a>
<h2>✏️ Засах бараа: <?php echo htmlspecialchars($name); ?></h2>

<form method="post" class="edit-form">
    <label>Нэр:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">

    <label>Тайлбар:</label>
    <input type="text" name="description" value="<?php echo htmlspecialchars($description); ?>">

    <label>Үнэ:</label>
    <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>">

    <label>Зургийн нэр (assets дотор):</label>
    <input type="text" name="image" value="<?php echo htmlspecialchars($image); ?>">

    <label>Ангилал:</label>
    <select name="category">
        <?php
        $categories = ["Цамц", "Өмд", "Дотуур хувцас", "Гутал", "Гадуур хувцас", "Даашинз", "Пиджак", "Спорт хувцас", "Унтлагын хувцас"];
        foreach ($categories as $cat) {
            $selected = ($category == $cat) ? 'selected' : '';
            echo "<option value=\"$cat\" $selected>$cat</option>";
        }
        ?>
    </select>

    <button type="submit">Шинэчлэх</button>
</form>

</body>
</html>
