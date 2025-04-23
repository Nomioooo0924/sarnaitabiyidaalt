<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<h1>🧥 Хувцасны дэлгүүр</h1>

<?php
$res = $conn->query("SELECT * FROM products");
while ($row = $res->fetch_assoc()) {
    echo "<div>
            <img src='assets/{$row['image']}' width='100'><br>
            <b>{$row['name']}</b> - {$row['price']}₮<br>
            <a href='product.php?id={$row['id']}'>Дэлгэрэнгүй</a>
          </div><hr>";
}
?>
