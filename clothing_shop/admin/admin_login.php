<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $res = $stmt->get_result();
    $admin = $res->fetch_assoc();

    if ($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "<p>Нэвтрэх нэр эсвэл нууц үг буруу байна.</p>";
    }
}
?>

<h2>🔐 Админ нэвтрэх</h2>
<form method="post">
    Нэвтрэх нэр: <input type="text" name="username"><br>
    Нууц үг: <input type="password" name="password"><br>
    <button type="submit">Нэвтрэх</button>
</form>
