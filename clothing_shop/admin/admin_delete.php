<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
include __DIR__ . '/../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM products WHERE id = $id");
}

header("Location: admin_panel.php");
exit;
