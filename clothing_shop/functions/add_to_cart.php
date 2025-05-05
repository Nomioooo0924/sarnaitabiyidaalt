<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Хэрвээ нэвтрээгүй бол шууд буцаана
    header("Location: login.php?msg=Эхлээд нэвтэрнэ үү.");
    exit;
}

// Энд бараа сагслах процесс үргэлжилнэ.
include 'includes/db.php';

$product_id = $_GET['id']; // Барааны ID-г авна
$user_id = $_SESSION['user_id'];

// Сагслах код (жишээ нь, carts гэсэн хүснэгт рүү нэмэх)
$stmt = $conn->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, 1)");
$stmt->bind_param("ii", $user_id, $product_id);
if ($stmt->execute()) {
    header("Location: cart.php?msg=Бараа сагслагдлаа!");
} else {
    echo "Алдаа гарлаа: " . $conn->error;
}
?>
