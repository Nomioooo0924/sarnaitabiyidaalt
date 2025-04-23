<?php
session_start();

function addToCart($productId, $qty = 1) {
    $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $qty;
}

function removeFromCart($productId) {
    unset($_SESSION['cart'][$productId]);
}

function clearCart() {
    $_SESSION['cart'] = [];
}
?>
