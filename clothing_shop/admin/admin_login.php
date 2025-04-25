<?php
session_start();
include __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "❌ Нэвтрэх мэдээлэл буруу!";
    }
}
?>

<h2>🔐 Админ нэвтрэх</h2>
<link rel="stylesheet" href="../style.css">
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post" class=admin>
    <label for="">И-мэйл:</label>
    <input type="email" name="email"><br><br>
    <label for="">Нууц үг:</label> 
    <input type="password" name="password"><br><br>
    <button type="submit">Нэвтрэх</button>
</form>
