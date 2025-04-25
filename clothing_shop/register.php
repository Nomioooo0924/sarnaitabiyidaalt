<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $pass);
    if ($stmt->execute()) {
        header("Location: login.php?msg=Амжилттай бүртгэгдлээ!");
        exit;
    } else {
        echo "Алдаа гарлаа: " . $conn->error;
    }
}
?>

<h2>Бүртгүүлэх</h2>
<form method="post">
<label for="">Нэр:</label> 
    <input type="text" name="name" required><br><br>
    <label for="">И-мэйл:</label>
    <input type="email" name="email" required><br><br>
    <label for="">Нууц үг:</label> 
    <input type="password" name="password" required><br><br>
    <button type="submit">Бүртгүүлэх</button>
</form>
<link rel="stylesheet" href="style.css">