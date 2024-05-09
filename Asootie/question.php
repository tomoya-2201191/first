<?php
    const SERVER = 'mysql302.phy.lolipop.lan';
    const DBNAME = 'LAA1516825-aso';
    const USER = 'LAA1516825';
    const PASS = 'aso1234';

    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
?>

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

    <div class="search">
        <div class="logo">
            <img src="img/asootie.png" alt="ロゴ">
        </div>
        <form action="#">
            <input type="text" id="searchInput" placeholder="Q&Aを探す">
            <button type="submit">検索</button>
        </form>
        <div class="icon">
            <img src="img/icon.png" height="80" weight="100">
        </div>
    </div>
</header>
<div class="question">
<a class="questionn" href="question.php" >aaaaaaaaaa</a>
</div>
<div class="a1"></div>

<div class="flex">

<div class="aaa">
    <?php
    $pdo= new PDO($connect,USER,PASS);
    $sql=$pdo->query('select * from user');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="q_user">';
    echo '<img src="img/icon.png" height="80" weight="100" class="icon">';
    echo "<p>",$row['name'],"　さん","</p>";
    echo '</div>';
    ?>
</div>

<div class="bbb">
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