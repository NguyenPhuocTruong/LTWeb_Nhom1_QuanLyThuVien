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
            <?php 
                require_once("../mysqlConnect.php");
                $mysqli->select_db("library");

                // ham hien thi anh bia va ten sach
                function display(array $row): void{
                    $image_encode = base64_encode($row['anh_bia']);
                    echo "
                        <div class=\"book_container\">
                            <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\"\"><img src=\"data:image/jpg;charset=utf8;base64,$image_encode\" alt=\"image\"></a><br><br>
                            <a href=\"./sanpham.php?ma_sach=" . $row['ma_sach'] . "\">" . $row['ten_sach'] . "</a>
                        </div>
                    ";
                }

                // ham xu ly du lieu user nhap vao, phong tranh sql injection
                function test_input(string $data): string{
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);

                    // loai bo nhung khoang trang du thua ben trong chuoi
                    $data = preg_replace('/ +/', ' ', $data);
                    return $data;
                }

                if (isset($_REQUEST['quoc_gia'])){
                    $quoc_gia = $_REQUEST['quoc_gia'];
                    echo "<h4 class=\"label\">" . (($quoc_gia == "vietnam") ? "sách việt nam":"foreign books") ."</h4>";

                    $result = $mysqli->query("SELECT * FROM sach WHERE quoc_gia = \"$quoc_gia\"");

                    while ($row = $result->fetch_assoc()){
                        display($row);
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
                        display($row);
                    }
                } else if (isset($_REQUEST['tac_gia'])){
                    $tac_gia = $_REQUEST['tac_gia'];
                    echo "<h4 class=\"label\">Sách được viết bởi: $tac_gia</h4>";

                    $result = $mysqli->query("SELECT * FROM sach WHERE tac_gia=\"$tac_gia\"");
                    while ($row = $result->fetch_assoc()){
                        display($row);
                    }
                } else if ($_SERVER['REQUEST_METHOD'] == "POST"){
                    $book_name = $_POST['bookname'];

                    // test input
                    $book_name = test_input($book_name);

                    // tim kiem trong csdl
                    $stm = $mysqli->prepare("SELECT * FROM sach WHERE ten_sach LIKE ?");
                    $stm->bind_param("s", $book_name);
                    if ($stm->execute()){
                        $result = $stm->get_result();
                        if ($result->num_rows > 0){
                            $row = $result->fetch_assoc();
                            $the_loai = $row['the_loai'];
                            $quoc_gia = $row['quoc_gia'];
                            $native = ($quoc_gia == "vietnam") ? "sách tiếng việt":"foreign books";
                            echo "<h4 class=\"label\">$native > $the_loai</h4>";
                            display($row);
                        } else echo "<h4 class=\"label\" style=\"color: red;\">Không tìm thấy sách: $book_name</h4>";
                    } else echo "<h4 class=\"label\" style=\"color: red;\">Lỗi trong lúc tìm sách: " . $stm->error . "</h4>";
                    $stm->close();
                }
            ?>
        </div>
    </main>

    <?php include "../footer.php" ?>
</body>
</html>