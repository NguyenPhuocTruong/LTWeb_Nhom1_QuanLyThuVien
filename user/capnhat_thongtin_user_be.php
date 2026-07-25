<?php session_start() ?>

<?php 
    require_once("../mysqlConnect.php");

    // function to test user input
    function test_input(string $data): string {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    function validEmail(string $email): bool { 
        return (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) ? true:false;
    }

    function validName(string $name): bool {
        // ten chi duoc chua chu cai va khoang trang
        return preg_match("/^[a-zA-Z-' ]*$/", $name);
    }

    // if (isset($_REQUEST['email']) and isset($_REQUEST['hoten'])){
        $newEmail = $_REQUEST['email'];
        $newName = $_REQUEST['hoten'];
        $oldEmail = $_SESSION['email'];

        $response = "";

        if (!validEmail(test_input($newEmail))) $response = "alert(\"Email không hợp lệ\")";
        else if (!validName(test_input($newName))) $response = "alert(\"Họ tên chỉ được chứa chữ cái và khoảng trắng\")";
        else {
            // update thong tin user trong bang nguoidung
            $stm = $mysqli->prepare("UPDATE nguoidung SET email = ?, hoten = ? WHERE email = '$oldEmail'");
            $stm->bind_param("ss", $newEmail, $newName);
            if ($stm->execute()){
                // thay doi gia tri session
                $_SESSION['email'] = $newEmail;
                $_SESSION['name'] = $newName;

                $response = "
                    alert('Đã lưu những thay đổi');
                    window.location.href = './thongtin_user.php';
                ";
            } else $response = "alert(\"Xảy ra lỗi trong quá trình thay đổi thông tin: " . $stm->error . "\")";
        }

        // if (validEmail(test_input($newEmail))){
        //     if (validName(test_input($newName))){
        //         // update thong tin user trong bang nguoidung
        //         $stm = $mysqli->prepare("UPDATE nguoidung SET email = ?, hoten = ? WHERE email = '$oldEmail'");
        //         $stm->bind_param("ss", $newEmail, $newName);
        //         if ($stm->execute()){
        //             // thay doi gia tri session
        //             $_SESSION['email'] = $newEmail;
        //             $_SESSION['name'] = $newName;

        //             $response = "
        //                 alert('Đã lưu những thay đổi');
        //                 window.location.href = './thongtin_user.php';
        //             ";
        //         } else $response = "alert(\"Xảy ra lỗi trong quá trình thay đổi thông tin: " . $stm->error . "\")";
        //     } else $response = "alert(\"Họ tên chỉ được chứa chữ cái và khoảng trắng\")";
        // } else $response = "alert(\"Email không hợp lệ\")";
        echo $response;
    // }
?>