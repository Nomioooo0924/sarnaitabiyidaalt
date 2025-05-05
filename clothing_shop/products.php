<?php
session_start();
include 'includes/db.php';

// Хайлтын утга шалгах
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM products";
}

$res = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Бараанууд</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .add-cart-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
        }
        .disabled-button {
            background-color: gray;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            pointer-events: none;
        }
        .product {
            background: #fff;
            padding: 15px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
            text-align: center;
        }
        .search-form {
            margin: 20px 0;
            text-align: center;
        }
        .search-input {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 200px;
        }
        .search-button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<h1>Бүх бараа</h1>

<!-- Хайлтын хэсэг -->
<div class="search-form">
    <form method="GET" action="angilal.php">
        <input type="text" name="search" class="search-input" placeholder="Бараа хайх...">
        <button type="submit" class="search-button">Хайх</button>
    </form>
</div>

<div class="product-list">
<?php if (count($products) > 0): ?>
    <?php foreach ($products as $product): ?>
        <div class="product">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p>Үнэ: <?= number_format($product['price']) ?>₮</p>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="product.php?id=<?= $product['id'] ?>" class="add-cart-button">Дэлгэрэнгүй</a>
            <?php else: ?>
                <a href="login.php?msg=Нэвтэрч ороод бараа үзнэ үү." class="disabled-button">Нэвтрэх шаардлагатай</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Илэрц олдсонгүй.</p>
<?php endif; ?>
</div>

</body>
</html>
