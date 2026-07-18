<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user profile test</title>
</head>
<body>
    <h3>Thong tin ca nhan:</h3><br>
    <?php 
        $email = $_SESSION['email'];
        $name = $_SESSION['name'];
        $sach_da_muon = $_SESSION['sach_da_muon'];
        $so_luong = count($sach_da_muon);
        echo "<h4>Email: $email</h4><br><h4>Ho ten: $name</h4><br><h4>Sach da muon: $so_luong</h4><br>";
        $i = 0;
        foreach ($sach_da_muon as $ma_sach=>$ten_sach){
            echo "<a href=\"./sanpham.php?ma_sach=$ma_sach\">" . $ten_sach . "</a> (Ma sach: " . $ma_sach . ")<br>";
        }
    ?>
    <a href="./trangchu.php"><button>Quay ve trang chu</button></a>
    <a href="./dangxuat.php"><button>Dang xuat</button></a>
</body>
</html>