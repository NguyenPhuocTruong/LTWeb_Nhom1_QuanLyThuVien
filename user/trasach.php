<?php session_start() ?>

<?php
    require_once("../mysqlConnect.php");
    $mysqli->select_db("library");

    if (isset($_REQUEST['ma_sach']) and isset($_REQUEST['ten_sach'])){
        // lay thong tin nguoi muon va sach muon
        $email = $_SESSION['email'];
        $ma_sach = (int)$_REQUEST['ma_sach'];
        $ten_sach = $_REQUEST['ten_sach'];

        // xoa ma sach trong session cua user
        unset($_SESSION['sach_da_muon'][$ma_sach]);

        // cap nhat thong tin vao bang muon_sach
        $success = $mysqli->query("DELETE FROM muon_sach WHERE email = '$email' and ma_sach = '$ma_sach'");
        if ($success){
            // cap nhat lai so luong sach
            $success = $mysqli->query("UPDATE sach SET so_luong = so_luong + 1 WHERE ma_sach = $ma_sach");
            if ($success) {
                // header("Refresh:0; url=sanpham.php"); // tai lai trang de cap nhat front end
                echo "";
            }
            else echo "Xảy ra lỗi trong lúc trả sách";
        } else echo "Xảy ra lỗi trong lúc trả sách";
    }
?>