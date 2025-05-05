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
        $error = "Алдаа гарлаа: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Бүртгүүлэх</title>
    <style>
        /* --- CSS --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            width: 400px;
            text-align: center;
            animation: fadeIn 1s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .register-container h2 {
            margin-bottom: 25px;
            color: #333;
        }
        .register-container form {
            display: flex;
            flex-direction: column;
        }
        .register-container input {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .register-container button {
            background: #00c6ff;
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .register-container button:hover {
            background: #0072ff;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .register-container .login-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .register-container .login-link a {
            color: #00c6ff;
            text-decoration: none;
        }
        .register-container .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Бүртгүүлэх</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="name" placeholder="Нэр" required>
            <input type="email" name="email" placeholder="И-мэйл" required>
            <input type="password" name="password" placeholder="Нууц үг" required>
            <button type="submit">Бүртгүүлэх</button>
        </form>
        <div class="login-link">
            Бүртгэлтэй хэрэглэгч бол <a href="login.php">Нэвтрэх</a>
        </div>
    </div>
</body>
</html>
