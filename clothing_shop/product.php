<?php
session_start();
include 'includes/db.php';
include 'functions/cart.php';

$id = (int)$_GET['id'];
$res = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        // Session шалгалт зөв боловч, JavaScript дээр асууна
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
</head>
<body>

<form method="post" class="pro" id="add-to-cart-form">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <img src="assets/<?= htmlspecialchars($product['image']) ?>" width="200"><br>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p>Үнэ: <?= htmlspecialchars($product['price']) ?>₮</p>
    <button type="submit">Сагслах</button>
</form>

<script>
document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    <?php if (!isset($_SESSION['user_id'])): ?>
        e.preventDefault(); // формыг илгээхийг болиулна
        if (confirm('Та нэвтэрч байж бараагаа сагсална уу. Та нэвтрэх үү?')) {
            window.location.href = 'login.php';
        }
    <?php endif; ?>
});
</script>
<a href="index.php" class="back-button">Буцах</a>
</body>
</html>
