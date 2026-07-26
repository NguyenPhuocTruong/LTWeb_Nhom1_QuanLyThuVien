<?php
    session_start();
    require_once("../mysqlConnect.php");

    $error = ''; 

    if(isset($_POST['login'])){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
       
        if(empty($email) || empty($password)){
            $error = '<script>alert("Email và mật khẩu không được để trống!")</script>';
        } else {
            // lay ra hashed password cua user thong qua email
            $sql = 'SELECT * FROM nguoidung WHERE email=?';
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('s', $email);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 1){
                    $row = $result->fetch_assoc();
                    // kiem tra mat khau
                    if (password_verify($password, $row['mat_khau'])){
                        // kiem tra tai khoan co phai admin hay khong
                        if ($email === "library@admin.com"){
                            // chuyen huong den giao dien admin
                            echo '<script>
                                    alert("Xin Chào Admin!");
                                    window.location.href = "../admin/dashboard.php";
                                </script>';
                        } else {
                            // luu thong tin email va ho ten user vao session
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['name'] = $row['hoten'];
                            
                            // lay danh sach sach da muon cua user
                            $sql = "SELECT muon_sach.ma_sach, sach.ten_sach FROM muon_sach INNER JOIN sach ON muon_sach.ma_sach = sach.ma_sach 
                            WHERE muon_sach.email = '$email'";
                            $result = $mysqli->query($sql);
                            if ($result->num_rows > 0){
                                while ($row = $result->fetch_assoc()){
                                    // $_SESSION['sach_da_muon'] la mot associative array, ma_sach la key, ten_sach la value
                                    $_SESSION['sach_da_muon'][$row['ma_sach']] = $row['ten_sach'];
                                }
                            } else $_SESSION['sach_da_muon'] = array();

                            // thong bao dang nhap thanh cong va chuyen huong den trang truoc do
                            echo '<script>
                                alert("Đăng nhập thành công!");
                                window.location.href = "../user/trangchu.php";
                            </script>';
                            exit();
                        }
                    } else $error = '<script>alert("Email hoặc mật khẩu không chính xác!")</script>';
                } else $error = '<script>alert("Email hoặc mật khẩu không chính xác!")</script>';
            } else $error = '<script>alert("Lỗi trong lúc truy vấn dữ liệu đăng nhập!")</script>';
            $stmt->close();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets_auth/form.css">
    <title>Đăng nhập tài khoản</title>
</head>
<body>
    <div class="form-container">
        <div class="form-container__bg"></div>
        <div class="login_form-container__content">
            <div class="form-container__header">
                <h3>ĐĂNG NHẬP</h3>
            </div>
            <div class="form-container__form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div class="form-container__row">
                        <label class="form_label">Email:</label>
            
                        <input class="form_input" type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" placeholder="Nhập email của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Mật khẩu</label>
                        <input class="form_input" type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" placeholder="Nhập mật khẩu của bạn">
                    </div>
                   
                    <?php if(!empty($error)): ?>
                        <?php echo $error; ?>
                    <?php endif; ?>

                    <div class="form-container__row">
                        <button type="submit" class="btn btn-control" name="login">Đăng nhập</button>
                    </div>
                </form>
                <div><p class="form-login">Bạn chưa có tài khoản? <a href="dangky.php">Đăng kí</a></p></div>
                <div><p class="form-login"><a href="../user/trangchu.php">Quay về trang chủ</a></p></div>
            </div>
        </div>
    </div>
</body>
</html>