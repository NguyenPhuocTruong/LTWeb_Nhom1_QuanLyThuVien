<?php
require_once("../mysqlConnect.php");
$conn->select_db("library");
if (isset($_GET['id'])) {
    $email_hien_tai = $_GET['id']; // Lấy email từ URL

    $sql = "SELECT * FROM nguoidung WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_hien_tai);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('Không tìm thấy người dùng!'); window.location.href='users.php';</script>";
        exit;
    }
} else {
    header("Location: users.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_email = $_POST['old_email'];
    $hoten = $_POST['hoten'];
    $new_email = $_POST['email'];
    $mat_khau_moi = $_POST['mat_khau'];

    if (!empty($mat_khau_moi)) {
        $mat_khau_bam = password_hash($mat_khau_moi, PASSWORD_DEFAULT);
        $sql_update = "UPDATE nguoidung SET hoten = ?, email = ?, mat_khau = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssss", $hoten, $new_email, $mat_khau_bam, $old_email);
    } else {
        $sql_update = "UPDATE nguoidung SET hoten = ?, email = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sss", $hoten, $new_email, $old_email);
    }

    if ($stmt_update->execute()) {
        echo "<script>
                alert('Cập nhật thông tin thành công!');
                window.location.href = 'users.php';
              </script>";
    } else {
        echo "<script>alert('Lỗi cập nhật: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa người dùng</title>
    <link rel="stylesheet" href="../assets_admin/css/sidebar.css">
    <link rel="stylesheet" href="../assets_admin/css/books.css">
    <link rel="stylesheet" href="../assets_admin/css/btnuser.css">
    <link rel="stylesheet" href="../assets_admin/css/editUser.css">

</head>

<body class="admin-body">
    <div class="books-page">
        <div class="admin-layout">
            <?php include "sidebar.php"; ?>
            <main class="books-content">
                <div class="books-header">
                    <h2>Chỉnh sửa người dùng</h2>
                </div>

                <div class="books-table-box" style="display: flex; justify-content: center;">
                    <div class="form-container">
                        <form method="POST" action="">
                            <input type="hidden" name="old_email"
                                value="<?php echo htmlspecialchars($user['email']); ?>">

                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="hoten" value="<?php echo htmlspecialchars($user['hoten']); ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Mật khẩu mới</label>
                                <input type="password" name="mat_khau" placeholder="Nhập mật khẩu mới nếu muốn đổi">
                                <small style="color: gray;">Để trống nếu bạn muốn giữ nguyên mật khẩu cũ</small>
                            </div>

                            <button type="submit" class="btn-submit">Lưu thay đổi</button>
                            <a href="users.php" class="btn-cancel">Hủy bỏ</a>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>