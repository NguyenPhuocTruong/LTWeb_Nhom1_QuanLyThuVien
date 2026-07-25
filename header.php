<?php session_start(); ?>

<div class="upper_header"></div>
    <div class="lower_header">
        <a href="./trangchu.php"><div class="logo"></div></a>
        <div class="search">
            <div class="search_bar">
                <form action="./display_books.php" method="post" id="search_form" autocomplete="off">
                    <button class="search_button" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input onkeyup="showHint(this.value)" onclick="showHint(this.value)" type="search" placeholder="Tìm tên sách..." name="bookname" value="<?php if (isset($_POST['bookname'])) echo $_POST['bookname'] ?>">
                </form>
                <script>
                    function showHint(str){
                        if (str.length == 0){
                            document.getElementById("hint").innerHTML = "";
                            return;
                        } else {
                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200){
                                    document.getElementById("hint").innerHTML = this.responseText;
                                }
                            };
                            xhr.open("GET", "./search.php?f=" + str, true); // true la bat dong bo
                            xhr.send();
                        }
                    }
                </script>

                <!-- thanh dropdown goi y ket qua tim kiem -->
                <div class="dropdown_result" id="hint"></div>
            </div>
            <div class="login_container">
                <div class="login">
                    <i class="fa-solid fa-phone" style="font-size: 40px;"></i>
                    <div><a href="" style="font-size: 19px; font-weight: bolder;">12345678</a><br><a href="" style="font-size: 15px;">Trợ giúp</a></div>
                </div>
                <div class="login">
                    <i class="fa-solid fa-circle-user" style="font-size: 50px;"></i>
                    <div id="login"><a href="../auth/dangnhap.php" style="font-size: 19px; font-weight: bolder;">Đăng nhập</a><br><a href="../auth/dangky.php" style="font-size: 15px;">Đăng ký</a></div>
                </div>
                <?php 
                    // check session
                    if (isset($_SESSION['email'])){
                    echo "
                        <script>
                            const div = document.getElementById(\"login\");
                            div.innerHTML = \"<a href=\\\"./thongtin_user.php\\\" style=\\\"font-size: 19px; font-weight: bolder;\\\">Tài khoản</a>\"
                        </script>
                    ";
                    }
                ?>
            </div>
        </div>
        <div class="catalogue">
            <ul>
                <li class="dropdown">
                    <a href="./display_books.php?quoc_gia=vietnam">Sách Việt Nam <i class="fa-solid fa-angle-down"></i></a>
                    <div class="dropdown_content">
                        <?php 
                            require_once("../mysqlConnect.php");
                            $mysqli->select_db("library");

                            $result = $mysqli->query("SELECT DISTINCT the_loai FROM sach WHERE quoc_gia=\"vietnam\"");
                            while ($row = $result->fetch_assoc()){
                                $the_loai = $row['the_loai'];
                                echo "<a href=\"./display_books.php?the_loai=$the_loai\">$the_loai</a>";
                            }
                        ?>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="./display_books.php?quoc_gia=nuocngoai">Foreign Books <i class="fa-solid fa-angle-down"></i></a>
                    <div class="dropdown_content">
                        <?php 
                            $result = $mysqli->query("SELECT DISTINCT the_loai FROM sach WHERE quoc_gia=\"nuocngoai\"");
                            while ($row = $result->fetch_assoc()){
                                $the_loai = $row['the_loai'];
                                echo "<a href=\"./display_books.php?the_loai=$the_loai\">$the_loai</a>";
                            }
                        ?>
                    </div>
                </li>
                <li class="dropdown">
                    <p style="font-weight: bold;">Tác Giả <i class="fa-solid fa-angle-down"></i></p>
                    <div class="dropdown_content">
                        <?php 
                            $result = $mysqli->query("SELECT DISTINCT tac_gia FROM sach");
                            while ($row = $result->fetch_assoc()){
                                $tac_gia = $row['tac_gia'];
                                echo "<a href=\"./display_books.php?tac_gia=$tac_gia\">$tac_gia</a>";
                            }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>