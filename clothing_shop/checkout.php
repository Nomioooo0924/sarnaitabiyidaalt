<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = "checkout.php";
    header("Location: login.php?msg=Та нэвтэрч орно уу");
    exit;
}

include 'includes/db.php';
include 'functions/cart.php';

$user_id = $_SESSION['user_id'];
$conn->query("INSERT INTO orders (user_id) VALUES ($user_id)");
$order_id = $conn->insert_id;

foreach ($_SESSION['cart'] as $product_id => $qty) {
    $res = $conn->query("SELECT price FROM products WHERE id=$product_id");
    $price = $res->fetch_assoc()['price'];
    $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price)
                  VALUES ($order_id, $product_id, $qty, $price)");
}

clearCart();
echo "<p>Захиалга амжилттай илгээгдлээ!</p>";
?>
