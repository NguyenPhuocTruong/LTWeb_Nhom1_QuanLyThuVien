<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user profile test</title>
</head>
<body>
    <h1 style="color: chartreuse;">Ban da dang ky thanh cong</h1><br><br>
    <h3>Thong tin ca nhan:</h3><br>
    <?php 
        $email = $_SESSION['email'];
        $name = $_SESSION['name'];
        echo "<h4>Email: $email</h4><br><h4>Ho ten: $name</h4>";
    ?>
    <a href="./user/trangchu.php"><button>Quay ve trang chu</button></a>
    <a href="./logOut_test.php"><button>Dang xuat</button></a>
</body>
</html>