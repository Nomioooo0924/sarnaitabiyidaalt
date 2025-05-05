<?php
session_start();
include 'includes/db.php';

// Хэрэглэгчийн мэдээлэл авах
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Мэдээллийг нь авчирч, дэлгэцэнд гаргах
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
} else {
    // Хэрэв хэрэглэгч нэвтрээгүй бол, дахин нэвтэрч ороход чиглүүлэх
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Өөрийн профайл</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Өөрийн профайл</h1>

<div class="profile-container">
    <p><strong>Нэр:</strong> <?= htmlspecialchars($user['name']) ?> <?= htmlspecialchars($user['last_name']) ?></p>
    <p><strong>Имэйл:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Утасны дугаар:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Хаяг:</strong> <?= htmlspecialchars($user['address']) ?></p>

    <a href="profile_edit.php">Профайлаа засах</a>
    <a href="logout.php" class="btn-logout">Гарах</a>
</div>

</body>
</html>
