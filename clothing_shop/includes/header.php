<?php session_start(); ?>
<nav>
    <a href="index.php">Нүүр</a> |
    <a href="cart.php">Сагс</a> |
    <?php if (isset($_SESSION['user_id'])): ?>
        Сайн байна уу, <?= $_SESSION['name'] ?> |
        <a href="logout.php">Гарах</a>
    <?php else: ?>
        <a href="login.php">Нэвтрэх</a> |
        <a href="register.php">Бүртгүүлэх</a>
    <?php endif; ?>
</nav>
<hr>
