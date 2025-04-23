<?php
include 'includes/db.php';
include 'functions/cart.php';
include 'includes/header.php';

echo "<h2>🛒 Таны сагс</h2>";

$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $qty) {
        $res = $conn->query("SELECT * FROM products WHERE id=$productId");
        $product = $res->fetch_assoc();
        $lineTotal = $product['price'] * $qty;
        $total += $lineTotal;

        echo "<p>{$product['name']} - $qty ширхэг - $lineTotal₮</p>";
    }
    echo "<h3>Нийт: $total₮</h3>";
    echo "<a href='checkout.php'>Захиалах</a>";
} else {
    echo "<p>Сагс хоосон байна.</p>";
}
?>
