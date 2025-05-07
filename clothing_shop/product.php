<?php
session_start();
include 'includes/db.php';
include 'functions/cart.php';

$id = (int)$_GET['id'];
$res = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php?msg=Та эхлээд нэвтэрнэ үү");
        exit;
    }
    addToCart($id);
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }

        .container {
            max-width: 800px;
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

        .product-image {
            display: block;
            margin: 0 auto 20px;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-details p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .price {
            font-size: 20px;
            color: #28a745;
            font-weight: bold;
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
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <img src="assets/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
    <div class="product-details">
        <p><?= htmlspecialchars($product['description']) ?></p>
        <p class="price">Үнэ: <?= htmlspecialchars($product['price']) ?>₮</p>

        <!-- Шинээр нэмсэн ангиллын мэдээллүүд -->
        <p><strong>Брэнд:</strong> <?= htmlspecialchars($product['brand']) ?></p>
        <p><strong>Улирал:</strong> <?= htmlspecialchars($product['uliral']) ?></p>
        <p><strong>Материал:</strong> <?= htmlspecialchars($product['material']) ?></p>
        <p><strong>Ангилал:</strong> <?= htmlspecialchars($product['nasangilal']) ?></p>
        <p><strong>Үндсэн өнгө:</strong> <?= htmlspecialchars($product['yrunhiungu']) ?></p>
    </div>

    <form method="post" id="add-to-cart-form">
        <button type="submit">Сагслах</button>
    </form>
    <a href="index.php" class="back-link">← Буцах</a>
</div>

<script>
document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    <?php if (!isset($_SESSION['user_id'])): ?>
        e.preventDefault();
        if (confirm('Та нэвтэрч байж бараагаа сагсална уу. Та нэвтрэх үү?')) {
            window.location.href = 'login.php';
        }
    <?php endif; ?>
});
</script>

</body>
</html>
