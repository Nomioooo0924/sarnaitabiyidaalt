<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $redirect = $_SESSION['redirect_after_login'] ?? "index.php";
        unset($_SESSION['redirect_after_login']);
        header("Location: $redirect");
        exit;
    } else {
        echo "<p>Нууц үг эсвэл и-мэйл буруу байна.</p>";
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2 >Нэвтрэх</h2>
<form method="post" class=login>
    <label for="">И-мэйл:</label>
    <input type="email" name="email" required><br><br>
    <label for="">Нууц үг:</label> 
    <input type="password" name="password" required><br><br>
    <button type="submit">Нэвтрэх</button>
</form>
