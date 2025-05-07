<?php
// angilal.php
session_start();

// Алдаа мэдэгдэх тохиргоо
error_reporting(E_ALL);
ini_set('display_errors', 1);

// db.php файлын замыг тодорхойлох
$dbFile = __DIR__ . '/includes/db.php';
if (!file_exists($dbFile)) {
    die("Алдаа: шаардлагатай файлын db.php-ыг олдсонгүй. Хүссэн байршил: $dbFile");
}

// Мэдээллийн сантай холбогдох
require_once $dbFile; // энд $conn орж ирнэ

// Холболт шалгах: mysqli_connect_errno() ашиглан
if (mysqli_connect_errno()) {
    die('Мэдээллийн сантай холбогдоход алдаа гарлаа: ' . mysqli_connect_error());
}

// Ангиллын хүснэгтээс бүх ангиллыг авах SQL
$sql = "SELECT id, name FROM categories ORDER BY name ASC";
$result = mysqli_query($conn, $sql);

// SQL алдааг шалгах
if ($result === false) {
    die('Ангиллыг унших SQL алдаа: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Ангилалын жагсаалт</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Бүх ангилал</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li>
                    <a href="products.php?category_id=<?php echo $row['id']; ?>">
                        <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Ангилал олдсонгүй.</p>
    <?php endif; ?>

    <?php
    // Нөөц чөлөөлөх
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</body>
</html>
