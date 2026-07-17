<?php
require_once("../mysqlConnect.php");
$conn->select_db("library");

$isEditMode = false;
$bookData = [];
$message = "";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $isEditMode = true;
    $ma_sach_edit = $_GET['id'];
    $result = $conn->query("SELECT * FROM sach WHERE ma_sach = '$ma_sach_edit'");
    if ($result && $result->num_rows > 0) {
        $bookData = $result->fetch_assoc();
    } else {
        $message = "<p style='color: red;'>Không tìm thấy sách này!</p>";
        $isEditMode = false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_sach = $_POST['ten_sach'];
    $tac_gia = $_POST['tac_gia'];
    $nam_xb = $_POST['nam_xb'];
    $nha_xb = $_POST['nha_xb'];
    $nha_cung_cap = $_POST['nha_cung_cap'];
    $the_loai = $_POST['the_loai'];
    $quoc_gia = $_POST['quoc_gia'];
    $so_luong = $_POST['so_luong'];
    $mo_ta = $_POST['mo_ta'];
    if (isset($_POST['ma_sach_hidden']) && !empty($_POST['ma_sach_hidden'])) {
        $ma_sach_update = $_POST['ma_sach_hidden'];

        if (isset($_FILES['anh_bia']) && $_FILES['anh_bia']['error'] === UPLOAD_ERR_OK) {
            $image_data = file_get_contents($_FILES['anh_bia']['tmp_name']);
            $stm = $conn->prepare("UPDATE sach SET ten_sach=?, tac_gia=?, nam_xb=?, nha_xb=?, nha_cung_cap=?, the_loai=?, quoc_gia=?, so_luong=?, mo_ta=?, anh_bia=? WHERE ma_sach=?");
            $stm->bind_param("ssissssissi", $ten_sach, $tac_gia, $nam_xb, $nha_xb, $nha_cung_cap, $the_loai, $quoc_gia, $so_luong, $mo_ta, $image_data, $ma_sach_update);
        } else {
            $stm = $conn->prepare("UPDATE sach SET ten_sach=?, tac_gia=?, nam_xb=?, nha_xb=?, nha_cung_cap=?, the_loai=?, quoc_gia=?, so_luong=?, mo_ta=? WHERE ma_sach=?");
            $stm->bind_param("ssissssisi", $ten_sach, $tac_gia, $nam_xb, $nha_xb, $nha_cung_cap, $the_loai, $quoc_gia, $so_luong, $mo_ta, $ma_sach_update);
        }

        if ($stm->execute()) {
            $message = "<p style='color: green; font-weight: bold; margin-bottom: 20px;'>Cập nhật sách thành công!</p>";
            $result = $conn->query("SELECT * FROM sach WHERE ma_sach = '$ma_sach_update'");
            $bookData = $result->fetch_assoc();
        } else {
            $message = "<p style='color: red;'>Lỗi khi cập nhật: " . $stm->error . "</p>";
        }
        $stm->close();
    } else {
        if (isset($_FILES['anh_bia']) && $_FILES['anh_bia']['error'] === UPLOAD_ERR_OK) {
            $image_data = file_get_contents($_FILES['anh_bia']['tmp_name']);
            $stm = $conn->prepare("INSERT INTO sach (ten_sach, tac_gia, nam_xb, nha_xb, nha_cung_cap, the_loai, quoc_gia, so_luong, mo_ta, anh_bia) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stm->bind_param("ssissssiss", $ten_sach, $tac_gia, $nam_xb, $nha_xb, $nha_cung_cap, $the_loai, $quoc_gia, $so_luong, $mo_ta, $image_data);

            if ($stm->execute()) {
                $message = "<p style='color: green; font-weight: bold;'>Thêm sách mới thành công!</p>";
            } else {
                $message = "<p style='color: red;'>Lỗi khi thêm sách: " . $stm->error . "</p>";
            }
            $stm->close();
        } else {
            $message = "<p style='color: red;'>Vui lòng chọn ảnh bìa hợp lệ!</p>";
        }
    }
    $check_tl = $conn->query("SELECT * FROM theloai WHERE ten_the_loai = '$the_loai'");
    if ($check_tl && $check_tl->num_rows == 0) {
        $stm_tl = $conn->prepare("INSERT INTO theloai (ten_the_loai) VALUES (?)");
        $stm_tl->bind_param("s", $the_loai);
        $stm_tl->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Đổi Title linh hoạt -->
    <title><?php echo $isEditMode ? "Sửa thông tin sách" : "Thêm sách mới"; ?></title>

    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../assets_admin/css/sidebar.css">
    <link rel="stylesheet" href="../assets_admin/css/books.css">
    <link rel="stylesheet" href="../assets_admin/css/addbook.css">
</head>

<body class="admin-body">

    <?php include "../header.php"; ?>

    <div class="books-page">
        <div class="admin-layout">
            <?php include "sidebar.php"; ?>

            <main class="books-content">
                <div class="books-header">
                    <h2><?php echo $isEditMode ? "Sửa thông tin sách" : "Thêm sách mới"; ?></h2>
                </div>

                <div class="books-table-box">
                    <?php echo $message; ?>

                    <form
                        action="<?php echo $_SERVER['PHP_SELF']; ?><?php echo $isEditMode ? '?id=' . $_GET['id'] : ''; ?>"
                        method="post" enctype="multipart/form-data" class="book-form">
                        <?php if ($isEditMode): ?>
                            <input type="hidden" name="ma_sach_hidden" value="<?php echo $bookData['ma_sach']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Tên sách</label>
                            <input type="text" name="ten_sach" required
                                value="<?php echo isset($bookData['ten_sach']) ? htmlspecialchars($bookData['ten_sach']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Tác giả</label>
                            <input type="text" name="tac_gia" required
                                value="<?php echo isset($bookData['tac_gia']) ? htmlspecialchars($bookData['tac_gia']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Năm xuất bản</label>
                            <input type="number" name="nam_xb" required
                                value="<?php echo isset($bookData['nam_xb']) ? htmlspecialchars($bookData['nam_xb']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Nhà xuất bản</label>
                            <input type="text" name="nha_xb"
                                value="<?php echo isset($bookData['nha_xb']) ? htmlspecialchars($bookData['nha_xb']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Nhà cung cấp</label>
                            <input type="text" name="nha_cung_cap"
                                value="<?php echo isset($bookData['nha_cung_cap']) ? htmlspecialchars($bookData['nha_cung_cap']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Thể loại</label>
                            <input type="text" name="the_loai" required
                                value="<?php echo isset($bookData['the_loai']) ? htmlspecialchars($bookData['the_loai']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Quốc gia</label>
                            <input type="text" name="quoc_gia"
                                value="<?php echo isset($bookData['quoc_gia']) ? htmlspecialchars($bookData['quoc_gia']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="number" name="so_luong" required
                                value="<?php echo isset($bookData['so_luong']) ? htmlspecialchars($bookData['so_luong']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="mo_ta"
                                rows="5"><?php echo isset($bookData['mo_ta']) ? htmlspecialchars($bookData['mo_ta']) : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Ảnh bìa
                                <?php echo $isEditMode ? "(Bỏ trống nếu không muốn đổi ảnh)" : "*"; ?></label>
                            <!-- Chỉ bắt buộc chọn ảnh nếu là Thêm mới -->
                            <input type="file" name="anh_bia" <?php echo $isEditMode ? "" : "required"; ?>>
                        </div>

                        <div class="form-button">
                            <input type="submit" value="<?php echo $isEditMode ? "Cập nhật sách" : "Thêm sách"; ?>"
                                class="btn-submit">
                            <button class="btn-back">
                                <a href="books.php">Hủy
                                    / Quay lại</a>
                            </button>
                            <input type="reset" value="Làm lại" class="btn-reset">
                        </div>

                    </form>

                </div>

            </main>

        </div>

    </div>

    <?php include "../footer.php"; ?>

    <script>
        if (window.history.replaceState)
            window.history.replaceState(null, null, window.location.href);
    </script>

</body>

</html>