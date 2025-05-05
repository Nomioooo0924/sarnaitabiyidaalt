<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style.css">

<!-- ✅ Navigation Bar -->
<nav class="navbar">
    <div class="navbar-logo">
        <a href="index.php">🧥 Хувцасны Дэлгүүр</a>
    </div>
    <ul class="navbar-menu">
        <li><a href="index.php">Нүүр</a></li>
      
        <li><a href="holboo.php">Холбоо барих</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="#">Сайн байна уу, <?= htmlspecialchars($_SESSION['name']) ?></a></li>
            <li><a href="logout.php">Гарах</a></li>
        <?php else: ?>
            <li><a href="login.php">Нэвтрэх</a></li>
            <li><a href="register.php">Бүртгүүлэх</a></li>
        <?php endif; ?>
    </ul>

    <!-- 🔍 Search form added here -->
    <div class="navbar-icons">
        <form action="search.php" method="GET" style="display: inline; margin: 0;">
            <input type="text" name="query" placeholder="Хайх..." style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
            <button type="submit" style="background: none; border: none; cursor: pointer;">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Хэрэглэгчийн бүртгэлд орох линк -->
    <a href="profile.php"><i class="fa fa-user"></i> </a>
   
<?php else: ?>
    <a href="#"><i class="fa fa-user"></i> </a>
<?php endif; ?>

    </div>

</nav>
<div class="container">
    <form method="GET" action="" class="category-form">
        <label for="category">Ангилал:</label>
        <select name="category" id="category" class="category-select" onchange="this.form.submit()">
            <option value="">Бүгд</option>
            <?php
            // Ангиллуудын массив
            $categories = ['Цамц', 'Өмд', 'Дотуур хувцас', 'Гутал', 'Гадуур хувцас', 'Малгай', 'Даашинз', 'Пиджак', 'Спорт хувцас', 'Унтлагын хувцас'];
            $selectedCategory = $_GET['category'] ?? '';

            foreach ($categories as $cat) {
                $selected = ($selectedCategory === $cat) ? 'selected' : '';
                echo "<option value='$cat' $selected>$cat</option>";
            }
            ?>
        </select>
    </form>
  
    <!-- Product List -->
    <div class="product-list">
        <?php
        $sql = "SELECT * FROM products";
        if (!empty($selectedCategory)) {
            $sql .= " WHERE category = '" . $conn->real_escape_string($selectedCategory) . "'";
        }
        $res = $conn->query($sql);

        while ($row = $res->fetch_assoc()) {
            echo "<div class='product-card'>
                    <img src='assets/{$row['image']}' alt='{$row['name']}'>
                    <h3>{$row['name']}</h3>
                    <p>{$row['price']}₮</p>
                    <a href='product.php?id={$row['id']}' class='btn-detail'>Дэлгэрэнгүй</a>
                  </div>";
        }
        ?>
    </div>
</div>
