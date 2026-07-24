<?php
require_once("../mysqlConnect.php");
$conn->select_db("library");

if (isset($_GET['id'])) {
    $email = $_GET['id'];

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
    header("Location: users.php");
}
