<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asoo!知恵袋</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/fade.css">  -->
</head>

<body>
    <div class="header-top"></div>

    <header>


        <div class="logo">
            <img src="img/asootie.png" alt="ロゴ">
        </div>

        <div class="search_box">

            <form method="get" action="#" class="search">
                  <div class="searchForm">
                    <input type="text" class="searchForm-input" placeholder="Q&Aを探す">
                    <button type="submit" class="searchForm-submit"></button>
                </div>
            </form>
        </div>

        <div class="icon">
            <img src="img/icon.png">
        </div>


    </header>

    
    <div class="question">
        <a class="questionn" href="question.php">aaaaaaaaaa</a>
    </div>
    
    <div class="a1"></div>

    <div class="flex">

        <div class="aaa"></div>
        <div class="right">
    <?php
    echo '<div class="category">';
    $sql=$pdo->query('select * from category');
    echo '<br>','　カテゴリ一覧';
    echo '<hr>';
    echo '<ul>';
    foreach ($sql as $row) {
        $id=$row['category_id'];
        echo '<li><a href="#?id=', $id, '">',$row['category_name'],"</li>";
        echo '<br>';
    }
    echo "</ul>";
    echo '<hr>';
    ?>
</div>

    </div>
    <script src="js/top.js"></script> <!-- JavaScriptファイルの読み込み -->
</body>

</html>