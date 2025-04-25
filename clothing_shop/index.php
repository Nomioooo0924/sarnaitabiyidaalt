<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<h1>🧥 Хувцасны дэлгүүр</h1>
<link rel="stylesheet" href="style.css">
<!-- 🔽 Ангиллын сонголт -->
<form method="GET" action="">
    <label>Ангилал:</label>
    <select name="category" onchange="this.form.submit()">
        <option value="">Бүгд</option>
        <?php
        // Ангиллуудын массив
        $categories = ['Цамц', 'Өмд', 'Дотуур хувцас', 'Гутал', 'Гадуур хувцас', 'Малгай', 'Даашинз', 'Пиджак', 'Спорт хувцас', 'Унтлагын хувцас'];
        $selectedCategory = $_GET['category'] ?? '';

        foreach ($categories as $cat) {
            $selected = ($selectedCategory === $cat) ? 'selected' : '';
            echo "<option value='$cat' $selected>$cat</option>";
        }
        ?>
    </select>
</form>

<!-- 🔽 Хувцас жагсаалт -->
<div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
<?php
$sql = "SELECT * FROM products";
if (!empty($selectedCategory)) {
    $sql .= " WHERE category = '" . $conn->real_escape_string($selectedCategory) . "'";
}
$res = $conn->query($sql);

while ($row = $res->fetch_assoc()) {
    echo "<div style='border:1px solid black; padding:10px; width:200px; text-align:center;border-radius:30px'>
            <img src='assets/{$row['image']}' width='150' height='150'><br>
            <b style='color:black'>{$row['name']}</b><br>
            <span style='color:#fff'>{$row['price']}₮</span><br>
            <a href='product.php?id={$row['id']}'>Дэлгэрэнгүй</a>
          </div>";
}
?>
</div>
