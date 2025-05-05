<?php
session_start();
include 'includes/db.php';

$query = $_GET['query'] ?? ''; // Хайлт хийсэн утга

// Хайлтын асуулт
if ($query) {
    $sql = "SELECT * FROM products WHERE name LIKE '%$query%'";
    $res = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    // Хэрэв хайлт байхгүй бол бүх барааг харуулна
    $sql = "SELECT * FROM products";
    $res = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Хайлт</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Навигацийн хэсэг -->
<nav class="navbar">
    <div class="navbar-logo">
        <a href="index.php">🧥 Хувцасны Дэлгүүр</a>
    </div>
    <ul class="navbar-menu">
        <li><a href="index.php">Нүүр</a></li>
        <li><a href="angilal.php">Ангилал</a></li>
        <li><a href="holboo.php">Холбоо барих</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="#">Сайн байна уу, <?= htmlspecialchars($_SESSION['name']) ?></a></li>
            <li><a href="logout.php">Гарах</a></li>
        <?php else: ?>
            <li><a href="login.php">Нэвтрэх</a></li>
            <li><a href="register.php">Бүртгүүлэх</a></li>
        <?php endif; ?>
    </ul>
</nav>

<!-- Хайлт хийх хэсэг -->
<div class="navbar-icons">
    <form action="search.php" method="GET" style="display: inline; margin: 0;">
        <input type="text" name="query" placeholder="Хайх..." value="<?= htmlspecialchars($query) ?>" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
        <button type="submit" style="background: none; border: none; cursor: pointer;">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>

<h1>Хайлт үр дүн</h1>

<div class="product-list">
<?php if (count($products) > 0): ?>
    <?php foreach ($products as $product): ?>
        <div class="product">
            <!-- Барааны зураг -->
            <img src="assets/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image" style="width: 200px; height:200px;">

            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p>Үнэ: <?= number_format($product['price']) ?>₮</p>
            <a href="product.php?id=<?= $product['id'] ?>" class="add-cart-button">Дэлгэрэнгүй</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Илэрц олдсонгүй.</p>
<?php endif; ?>
</div>
<a href="index.php" class="back-button">Буцах</a>   
</body>
</html>
