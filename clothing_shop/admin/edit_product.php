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
        echo "<p style='color: green; text-align:center;'>✅ Амжилттай засагдлаа!</p>";
    } else {
        echo "<p style='color: red; text-align:center;'>Алдаа: " . htmlspecialchars($conn->error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Бараа засах</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 30px;
            display: flex;
            justify-content: center;
        }   

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
            font-size: 24px;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #555;
            margin-bottom: 20px;
            display: inline-block;
            transition: color 0.3s;
        }

        a:hover {
            color: #1f8dd6;
        }

        form.edit-form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: border 0.3s;
        }

        input:focus,
        select:focus {
            border-color: #1f8dd6;
            outline: none;
        }

        button {
            margin-top: 25px;
            padding: 12px;
            background-color: #1f8dd6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #156ba3;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="admin_panel.php"><i class="fas fa-arrow-left"></i> Буцах</a>
    <h2>✏️ Засах бараа: <?php echo htmlspecialchars($name); ?></h2>

    <form method="post" class="edit-form">
        <label for="name">Нэр:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label for="description">Тайлбар:</label>
        <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($description); ?>" required>

        <label for="price">Үнэ:</label>
        <input type="number" name="price" step="0.01" id="price" value="<?php echo htmlspecialchars($price); ?>" required>

        <label for="image">Зургийн нэр (assets дотор):</label>
        <input type="text" name="image" id="image" value="<?php echo htmlspecialchars($image); ?>">

        <label for="category">Ангилал:</label>
        <select name="category" id="category">
            <?php
            $categories = ["Цамц", "Өмд", "Дотуур хувцас", "Гутал", "Гадуур хувцас", "Даашинз", "Пиджак", "Спорт хувцас", "Унтлагын хувцас"];
            foreach ($categories as $cat) {
                $selected = ($category == $cat) ? 'selected' : '';
                echo "<option value=\"" . htmlspecialchars($cat) . "\" $selected>" . htmlspecialchars($cat) . "</option>";
            }
            ?>
        </select>

        <button type="submit">Шинэчлэх</button>
    </form>
</div>

</body>
</html>
