<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
include '../includes/db.php';

$selectedCategory = $_GET['category'] ?? '';

// Ангиллаар шүүж авах
if ($selectedCategory) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $selectedCategory);
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    $res = $conn->query("SELECT * FROM products");
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Бараа удирдлага</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f4f8;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        select {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            min-width: 200px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a.action {
            color: #007BFF;
            margin: 0 6px;
            text-decoration: none;
        }

        a.action:hover {
            color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #555;
        }

        .back-link:hover {
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📦 Бараа удирдлага</h2>
    <h2><a  href="admin_add_product.php"> Бараа нэмэх</a></h2>
    <!-- Шүүлт -->
    <form method="get">
        
        <label for="category"><strong>Ангиллаар харах:</strong></label>
        <select name="category" id="category" onchange="this.form.submit()">
            <option value="">Бүх ангилал</option>
            <?php
            $categories = ["Цамц", "Өмд", "Дотуур хувцас", "Гутал", "Гадуур хувцас", "Малгай", "Даашинз", "Пиджак", "Спорт хувцас", "Унтлагын хувцас"];
            foreach ($categories as $cat) {
                $selected = ($selectedCategory == $cat) ? "selected" : "";
                echo "<option value=\"$cat\" $selected>$cat</option>";
            }
            ?>
        </select>
    </form>

    <!-- Хүснэгт -->
    <table>
        <tr>
            <th>Нэр</th>
            <th>Үнэ</th>
            <th>Ангилал</th>
            <th>Үйлдэл</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['price']) ?>₮</td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td>
                    <a class="action" href="edit_product.php?id=<?= $row['id'] ?>"><i class="fas fa-edit"></i></a>
                    <a class="action" href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Устгахдаа итгэлтэй байна уу?')"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div style="text-align:center;">
    
        <a class="back-link" href="admin_panel.php">← Буцах</a>
    </div>
</div>

</body>
</html>
