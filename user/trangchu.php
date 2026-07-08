<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../assets_user/trangchu.css">
    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/vnd.microsoft.icon" href="../images/sky4.jpg">
</head>
<body>
    <?php include '../header.php' ?>
    <main>
        <div class="book_area">
            <h2 class="label">sách việt nam | session email (test): <?php if (isset($_SESSION['email'])) echo $_SESSION['email'] ?></h2>
            <?php 
                require_once("../mysqlConnect.php");
                $mysqli->select_db("library");

                $result = $mysqli->query("SELECT * FROM sach WHERE quoc_gia = \"vietnam\"");

                while ($row = $result->fetch_assoc()){
                    $image_encode = base64_encode($row['anh_bia']);
                    echo "
                        <div class=\"book_container\">
                            <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\"\"><img src=\"data:image/jpg;charset=utf8;base64,$image_encode\" alt=\"image\"></a><br><br>
                            <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\">" . $row['ten_sach'] . "</a>
                        </div>
                    ";
                }
            ?>
        </div>
        <div class="book_area">
            <h2 class="label">foreign books</h2>
            <?php 
                $result = $mysqli->query("SELECT * FROM sach WHERE quoc_gia = \"nuocngoai\"");

                while ($row = $result->fetch_assoc()){
                    $image_encode = base64_encode($row['anh_bia']);
                    echo "
                        <div class=\"book_container\">
                            <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\"\"><img src=\"data:image/jpg;charset=utf8;base64,$image_encode\" alt=\"image\"></a><br><br>
                            <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\">" . $row['ten_sach'] . "</a>
                        </div>
                    ";
                }
            ?>
        </div>
    </main>
   <?php include '../footer.php' ?>
</body>
</html>