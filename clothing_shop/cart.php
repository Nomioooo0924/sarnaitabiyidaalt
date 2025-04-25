<?php
session_start();
include 'includes/db.php';

// Сагсанд бараа нэмэх
if (isset($_GET['action']) && $_GET['action'] == "add" && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    header("Location: cart.php");
    exit;
}

// Сагс хоослох
if (isset($_GET['action']) && $_GET['action'] == "clear") {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// Тодорхой барааг сагснаас хасах
if (isset($_GET['action']) && $_GET['action'] == "remove" && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}

echo "<h2>🛒 Миний сагс</h2>";

$total = 0;

if (!empty($_SESSION['cart'])) {
    echo "<table border='1' cellpadding='10'>
            <tr><th>Нэр</th><th>Үнэ</th><th>Тоо</th><th>Нийт</th><th>Устгах</th></tr>";

    foreach ($_SESSION['cart'] as $id => $qty) {
        $res = $conn->query("SELECT * FROM products WHERE id = $id");
        if ($row = $res->fetch_assoc()) {
            $subtotal = $row['price'] * $qty;
            $total += $subtotal;
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['price']}₮</td>
                    <td>$qty</td>
                    <td>{$subtotal}₮</td>
                    <td><a href='cart.php?action=remove&id={$id}' onclick='return confirm(\"Устгах уу?\")'>❌</a></td>
                  </tr>";
        }
    }

    echo "<tr><td colspan='3'><b>Нийт:</b></td><td><b>{$total}₮</b></td><td></td></tr>";
    echo "</table><br>";
    echo "<a href='cart.php?action=clear'>🧹 Сагс хоослох</a>";
} else {
    echo "Сагс хоосон байна.";
}

echo "<br><br><a href='index.php'>⬅️ Дахин бараа саглах</a>";
?>
