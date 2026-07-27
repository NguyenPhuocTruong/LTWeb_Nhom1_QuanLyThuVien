<?php session_start() ?>

<?php
    require_once("../mysqlConnect.php");
    $mysqli->select_db("library");

    if (isset($_REQUEST['ma_sach']) and isset($_REQUEST['ten_sach'])){
        // lay thong tin nguoi muon va sach muon
        $email = $_SESSION['email'];
        $ma_sach = (int)$_REQUEST['ma_sach'];
        $ten_sach = $_REQUEST['ten_sach'];

        // them ma sach va ten sach da muon vao session cua user
        $_SESSION['sach_da_muon'][$ma_sach] = $ten_sach;

        // cap nhat thong tin vao bang muon_sach
        $success = $mysqli->query("INSERT INTO muon_sach (email, ma_sach, so_luong_sach_muon) VALUES('$email', $ma_sach, 1)");
        if ($success){
            // cap nhat lai so luong sach
            $success = $mysqli->query("UPDATE sach SET so_luong = so_luong - 1 WHERE ma_sach = $ma_sach");
            if ($success) {
                echo "";
            }
            else echo "Xảy ra lỗi trong lúc mượn sách";
        } else echo "Xảy ra lỗi trong lúc mượn sách";
    }
?>