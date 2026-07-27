<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log out</title>
</head>
<body>
    <?php 
        session_unset();
        session_destroy();
        echo "<h1>BẠN ĐÃ ĐĂNG XUẤT...<h1>";
        echo "<a href=\"./trangchu.php\"><button>Quay về trang chủ</button></a>";
    ?>
</body>
</html>