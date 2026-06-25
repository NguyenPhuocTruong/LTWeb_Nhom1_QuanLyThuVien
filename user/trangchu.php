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
        <h2 class="label">Truyện tranh</h2>
        <div class="book_area">
            <?php 
                for ($i = 0; $i < 14; $i++){
                    echo "
                        <div class=\"book_container\">
                            hello $i
                        </div>
                    ";
                }
            ?>
        </div>
    </main>
   <?php include '../footer.php' ?>
</body>
</html>