<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asoo!知恵袋</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="header-top"></div>

    <header>
        <div class="logo">
            <img src="img/asootie.png" alt="ロゴ">
        </div>

        <div class="search_box">
            <form method="get" action="search.php" class="search">
                <div class="searchForm">
                    <input type="text" name="keyword" class="searchForm-input" placeholder="Q&Aを探す">
                    <button type="submit" class="searchForm-submit"></button>
                </div>
            </form>
        </div>

        <div class="icon">
            <img src="img/icon.png" alt="アイコン">
        </div>
    </header>

    <div class="question">
        <a class="questionn" href="question.php">aaaaaaaaaa</a>
    </div>
    <div class="a1"></div>

    <div class="flex">
        <div class="aaa">
            <?php
            // MySQL接続情報
            $servername = "mysql302.phy.lolipop.lan";
            $username = "LAA1516825";
            $password = "aso1234";
            $dbname = "LAA1516825-aso";

            // MySQLデータベースに接続
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // フォームからキーワードを取得
            if (isset($_GET['keyword'])) {
                $keyword = $_GET['keyword'];

                // キーワードを使用して検索クエリを作成
                $sql = "SELECT * FROM question WHERE q_text LIKE '%$keyword%'";
                $result = $conn->query($sql);

                // 検索結果を表示
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<p>" . $row["q_text"] . "</p>";
                    }
                } else {
                    echo "0 results";
                }
            }

            $conn->close();
            ?>
        </div>
        <div class="bbb"></div>
    </div>

    <script src="js/top.js"></script>
</body>

</html>
