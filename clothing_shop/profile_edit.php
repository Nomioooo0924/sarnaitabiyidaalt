<?php
session_start();
include 'includes/db.php';

// Хэрэглэгчийн мэдээллийг авах
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Хэрэглэгчийн шинэ мэдээллийг авах
        $name = $_POST['name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        // Өгөгдлийг шинэчлэх
        $sql = "UPDATE users SET name = '$name', last_name = '$last_name', phone = '$phone', address = '$address' WHERE id = '$userId'";
        if (mysqli_query($conn, $sql)) {
            echo "Мэдээлэл амжилттай шинэчлэгдсэн!";
        } else {
            echo "Алдаа гарлаа: " . mysqli_error($conn);
        }
    }

    // Өгөгдлийн сангаас мэдээлэл авах
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Профайл засварлах</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Өөрийн профайл засварлах</h1>

<form method="POST" action="">
    <label>Нэр:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
    <br>

    <label>Овог:</label>
    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
    <br>

    <label>Утасны дугаар:</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
    <br>

    <label>Хаяг:</label>
    <textarea name="address" required><?= htmlspecialchars($user['address']) ?></textarea>
    <br>

    <button type="submit">Шинэчлэх</button>
</form>
<a href="profile.php" class="back-button">Буцах</a>   
</body>
</html>
