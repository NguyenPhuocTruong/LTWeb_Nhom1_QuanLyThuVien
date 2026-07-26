<?php
require_once("../mysqlConnect.php");
$conn->select_db("library");
if (isset($_GET['id'])) {
    $ma_sach = $_GET['id'];
    $stm = $conn->prepare("DELETE FROM sach WHERE ma_sach = ?");
    $stm->bind_param("s", $ma_sach);
    if ($stm->execute()) {
        header("Location: books.php?msg=delete_success");
        exit();
    } else {
        echo "Loi khi xoa" . $conn->error;
    }
    $stm->close();
} else {
    header("Location: books.php");
    exit();
}
