<?php
session_start();
require_once("../mysqlConnect.php");

$error = '';

if (isset($_POST['dangki'])) {
    $email    = trim($_POST['email']);
    $hoten    = trim($_POST['hoten']);
    $password = trim($_POST['password']);
    $re_enter   = trim($_POST['re-enter']);
    $agree    = isset($_POST['check']);

    if (empty($email) || empty($hoten) || empty($password) || empty($re_enter)) {
        $error = '<script>alert("Vui lòng điền đầy đủ thông tin!")</script>';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '<script>alert("Email không hợp lệ!")</script>';
    } else if (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/", $hoten)){
        $error = '<script>alert("Họ tên chỉ được chứa chữ cái và khoảng trắng!")</script>';
    } else if (strlen($password) < 8) {
        $error = '<script>alert("Mật khẩu phải có ít nhất 8 ký tự!")</script>';
    } else if (!$agree) {
        $error = '<script>alert("Bạn cần đồng ý với Điều khoản dịch vụ và Chính sách bảo mật!")</script>';
    } else if ($password !== $re_enter){
        $error = '<script>alert("Mật khẩu không trùng khớp")</script>';
    } else {
        $checkSql = 'SELECT email FROM nguoidung WHERE email = ?';
        $checkStmt = $mysqli->prepare($checkSql);
        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            $error = '<script>alert("Email đã tồn tại!")</script>';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO nguoidung (email, hoten, mat_khau) VALUES (?, ?, ?)';
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param('sss', $email, $hoten, $hashedPassword);

                if ($stmt->execute()) {
                    // luu thong tin user vao session
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $hoten;
                    $_SESSION['sach_da_muon'] = array();

                    // thong bao dang ky thanh cong va chuyen huong den trang chu
                    echo '<script>
                        alert("Đăng ký thành công!");
                        window.location.href = "../user/trangchu.php";
                    </script>';
                    exit();
                } else {
                    $error = '<script>alert("Đăng ký thất bại, vui lòng thử lại!")</script>';
                }
                $stmt->close();
            }
        }
        $checkStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets_auth/form.css"> 
    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
    <title>Đăng ký tài khoản</title>
</head>
<body>
    <div class="form-container">
        <div class="form-container__bg"></div>
        <div class="signup_form-container__content">
            <div class="form-container__header">
                <h3>Tạo tài khoản của bạn</h3>
            </div>
            <div class="form-container__form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div class="form-container__row">
                        <label class="form_label">E-mail</label>
                        <input class="form_input" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" type="email" placeholder="Nhập email của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Họ và tên</label>
                        <input class="form_input" name="hoten" value="<?php if(isset($_POST['hoten'])) echo $_POST['hoten'];?>" type="text" placeholder="Nhập họ và tên của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Mật khẩu</label>
                        <input class="form_input" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" type="password" placeholder="Nhập mật khẩu của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Nhập lại mật khẩu</label>
                        <input class="form_input" name="re-enter" value="<?php if(isset($_POST['re-enter'])) echo $_POST['re-enter'];?>" type="password" placeholder="Nhập lại mật khẩu của bạn">
                    </div>
                    <div class="form_policy">
                        <input class="policy" type="checkbox" name="check"><label class="policy-text">Khi đăng kí, bạn đồng ý với chúng tôi về <a href="./policy.php" class="policy-a">Điều khoản dịch vụ</a> & <a href="./policy.php" class="policy-a">Chính sách bảo mật</a> 
                        </label>
                    </div>
                    <?php if(!empty($error)): ?>
                        <?php echo $error; ?>
                    <?php endif; ?>
                    <div class="form-container__row">
                        <button type="submit" class="btn btn-control" name="dangki">Tạo tài khoản</button>
                    </div>
                </form>
                <!-- <div class="form-container__social">
                    <button class="btn-social"><a href="" class="google-icon"><i class="fa-brands fa-google"></i>Đăng ký bằng Google</a></button>
                </div> -->
                <div><p class="form-login">Bạn đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></p></div>
                <div><p class="form-login"><a href="../user/trangchu.php">Quay về trang chủ</a></p></div>
            </div>
        </div>
    </div>
</body>
</html>