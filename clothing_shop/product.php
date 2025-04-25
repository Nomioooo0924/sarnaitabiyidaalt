<?php
include 'includes/db.php';
include 'functions/cart.php';



$id = $_GET['id'];
$res = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addToCart($id);
    header("Location: cart.php");
}
?>
<form method="post" class=pro>
<h2><?= $product['name'] ?></h2>
<img src="assets/<?= $product['image'] ?>" width="200"><br>
<p><?= $product['description'] ?></p>
<p>Үнэ: <?= $product['price'] ?>₮</p>
    <button type="submit">Сагслах</button>
</form>
<link rel="stylesheet" href="style.css">