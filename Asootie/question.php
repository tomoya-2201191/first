<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="contents"></div>

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

    <?php
    $sql=$pdo->query('select * from question where q_id = 1');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $id = $row['q_id'];
    echo '<div class="q_text">',$row['q_text'],'</div>';
    echo    '<button class="btn1">共感した</button><br><hr>';
    echo '<button class="check_answer"><a href="view-answer.php?q_id=' . $id . '">回答を見る＞</a></button>';
    echo '<button class="q_answer"><a href="ranking.php?q_id=' . $id . '">回答をする＞</a></button>';
    ?>
</div>

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