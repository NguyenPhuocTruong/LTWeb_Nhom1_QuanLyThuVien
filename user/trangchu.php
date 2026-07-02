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
            <h2 class="label">sách việt nam</h2>
            <?php 
                for ($i = 0; $i < 14; $i++){
                    echo "
                        <div class=\"book_container\">
                            <a href=\"./sanpham.php\"><img src=\"../assets_user/book_images/bon_thoa_uoc.webp\" alt=\"image\"></a><br><br>
                            <a href=\"./sanpham.php\">Bốn thỏa ước</a>
                        </div>
                    ";
                }
            ?>
        </div>
        <div class="book_area">
            <h2 class="label">foreign books</h2>
            <?php 
                for ($i = 0; $i < 14; $i++){
                    echo "
                        <div class=\"book_container\">
                            <a href=\"./sanpham.php\"><img src=\"../assets_user/book_images/nha_gia_kim.webp\" alt=\"image\"></a><br><br>
                            <a href=\"./sanpham.php\">Nhà giả kim</a>
                        </div>
                    ";
                }
            ?>
        </div>
    </main>
   <?php include '../footer.php' ?>
</body>
</html>