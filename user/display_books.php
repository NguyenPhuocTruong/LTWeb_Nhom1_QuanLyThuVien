<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../assets_user/trangchu.css">
    <link rel="icon" type="image/vnd.microsoft.icon" href="../images/sky4.jpg">
    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include "../header.php" ?>
        
    <main>
        <div class="book_area">
            <!-- <h2 class="label">sách việt nam</h2> -->
            <?php 
                require_once("../mysqlConnect.php");
                $mysqli->select_db("library");

                if (isset($_REQUEST['quoc_gia'])){
                    $quoc_gia = $_REQUEST['quoc_gia'];
                    if ($quoc_gia == "vietnam") echo "<h4 class=\"label\">sách việt nam</h4>";
                    else echo "<h4 class=\"label\">foreign books</h4>";

                    $result = $mysqli->query("SELECT * FROM sach WHERE quoc_gia = \"$quoc_gia\"");

                    while ($row = $result->fetch_assoc()){
                        $image_encode = base64_encode($row['anh_bia']);
                        echo "
                            <div class=\"book_container\">
                                <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\"\"><img src=\"data:image/jpg;charset=utf8;base64,$image_encode\" alt=\"image\"></a><br><br>
                                <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\">" . $row['ten_sach'] . "</a>
                            </div>
                        ";
                    }
                } else if (isset($_REQUEST['the_loai'])){
                    $the_loai = $_REQUEST['the_loai'];

                    // lay ra quoc gia cua the loai
                    $quoc_gia = $mysqli->query("SELECT quoc_gia FROM sach WHERE the_loai=\"$the_loai\"")->fetch_assoc()['quoc_gia'];
                    $native = ($quoc_gia == "vietnam") ? "sách việt nam":"foreign books";
                    echo "<h4 class=\"label\">$native > $the_loai</h4>";

                    // lay ra cac cuon sach thuoc the loai do
                    $result = $mysqli->query("SELECT * FROM sach WHERE the_loai = \"$the_loai\"");
                    while ($row = $result->fetch_assoc()){
                        $image_encode = base64_encode($row['anh_bia']);
                        echo "
                            <div class=\"book_container\">
                                <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\"\"><img src=\"data:image/jpg;charset=utf8;base64,$image_encode\" alt=\"image\"></a><br><br>
                                <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\">" . $row['ten_sach'] . "</a>
                            </div>
                        ";
                    }
                } else if (isset($_REQUEST['tac_gia'])){
                    $tac_gia = $_REQUEST['tac_gia'];

                    echo "<h4 class=\"label\">Sách được viết bởi: $tac_gia</h4>";
                    $result = $mysqli->query("SELECT * FROM sach WHERE tac_gia=\"$tac_gia\"");
                    while ($row = $result->fetch_assoc()){
                        $image_encode = base64_encode($row['anh_bia']);
                        echo "
                            <div class=\"book_container\">
                                <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\"\"><img src=\"data:image/jpg;charset=utf8;base64,$image_encode\" alt=\"image\"></a><br><br>
                                <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\">" . $row['ten_sach'] . "</a>
                            </div>
                        ";
                    }
                }
            ?>
        </div>
    </main>

    <?php include "../footer.php" ?>
</body>
</html>