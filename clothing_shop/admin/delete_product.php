<?php
session_start();
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Бараа устгах баталгаажуулах
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // Устгах үйлдэл
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "✅ Бараа амжилттай устгагдлаа! <a href='admin_panel.php'>Буцах</a>";
        } else {
            echo "Алдаа: " . $conn->error;
        }
    } else {
        // Баталгаажуулалтын хуудас гаргах
        echo "<h2>Та энэ барааг устгахыг хүсэж байна уу?</h2>";
        echo "<a href='delete_product.php?id=$id&confirm=yes'>Тийм</a> | <a href='admin_panel.php'>Үгүй</a>";
    }
} else {
    echo "Бараа олдсонгүй.";
}
?>
