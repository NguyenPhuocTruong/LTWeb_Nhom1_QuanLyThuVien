<?php
require_once("../mysqlConnect.php");
$conn->select_db("library");

// Nhận biến 'id' từ URL (thực chất giá trị bên trong là email)
if (isset($_GET['id'])) {
    $email = $_GET['id'];

    // Câu lệnh SQL tìm và xóa theo email
    $sql = "DELETE FROM nguoidung WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // 's' vì email là chuỗi (string)

    if ($stmt->execute()) {
        echo "<script>
                alert('Đã xóa thành viên thành công!');
                window.location.href = 'users.php';
              </script>";
    } else {
        echo "<script>
                alert('Có lỗi xảy ra: " . $conn->error . "');
                window.location.href = 'users.php';
              </script>";
    }
} else {
    // Không có dữ liệu thì tự quay về trang người dùng
    header("Location: users.php");
}
