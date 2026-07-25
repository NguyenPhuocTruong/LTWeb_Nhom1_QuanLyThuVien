<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">

    <div class="admin-logo">
        <i class="fa-solid fa-book-open-reader"></i>
        <span>Library Admin</span>
    </div>

    <a href="dashboard.php" class="<?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="fa-solid fa-chart-line"></i>
        <span>Thống kê</span>
    </a>

    <a href="books.php" class="<?= ($currentPage == 'books.php') ? 'active' : ''; ?>">
        <i class="fa-solid fa-book"></i>
        <span>Quản lý sách</span>
    </a>

    <a href="users.php" class="<?= ($currentPage == 'users.php') ? 'active' : ''; ?>">
        <i class="fa-solid fa-users"></i>
        <span>Quản lý người dùng</span>
    </a>

    <a href="logout.php">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Đăng xuất</span>
    </a>

</div>