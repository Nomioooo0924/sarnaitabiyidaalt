<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
include __DIR__ . '/../includes/db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];


    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category,brand ) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $desc, $price, $image, $category, $brand);
    if ($stmt->execute()) {
        $success = "✅ Амжилттай нэмэгдлээ!";
    } else {
        $error = "❌ Алдаа: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Бараа нэмэх</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
        }

        .success { background: #e0ffe0; color: #2e7d32; }
        .error { background: #ffe0e0; color: #c62828; }

        form label {
            display: block;
            margin-bottom: 5px;
            margin-top: 15px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #218838;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #555;
            text-decoration: none;
        }

        .back-link:hover {
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>➕ Шинэ бараа нэмэх</h2>

    <?php if ($success): ?>
        <div class="message success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Барааны нэр</label>
        <input type="text" name="name" required>
        <label>Бренд</label>
        <input type="text" name="brand" required>

        <label>Тайлбар</label>
        <input type="text" name="description" required>

        <label>Улирал</label>
        <input type="text" name="uliral" required >
        
        <label>Насны ангилал</label>
        <input type="text" name="nasangilal" required >
        
      
        <label>Ерөнхий өнгө</label>
        <input type="text" name="yrunhiungu" required >

        <label>Үнэ (₮)</label>
        <input type="number" name="price" required step="0.01">

        <label>Зургийн нэр (assets хавтсанд байгаа)</label>
        <input type="text" name="image" required>

        <label>Ангилал</label>
        <select name="category" required>
            <option value="">-- Сонгоно уу --</option>
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
        </select>

        <button type="submit">Нэмэх</button>
    </form>

    <a href="admin_panel.php" class="back-link">← Админ самбар руу буцах</a>
</div>

</body>
</html>
