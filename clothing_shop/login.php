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

<h2>Нэвтрэх</h2>
<form method="post">
    И-мэйл: <input type="email" name="email" required><br>
    Нууц үг: <input type="password" name="password" required><br>
    <button type="submit">Нэвтрэх</button>
</form>
