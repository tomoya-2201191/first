<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="contents"></div>

<div class="flex">

<div class="left">
    <?php
    $pdo= new PDO($connect,USER,PASS);
    $sql=$pdo->query('select * from user');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="q_user">';
    echo '<img src="img/icon.png" height="80" width="100">';
    echo '<div class="q_profile">',$row['name'],'　さん','<br>';
    if($row['status_id'] == 0){
        echo    '<div class="box1">
                <div class="status1">STUDENT</div>
                </div>'; // コメントの修正: 閉じタグを追加
    }else if($row['status_id'] == 1){
        echo    '<div class="box2">
                <div class="status2">TEACHER</div>
                </div>'; // コメントの修正: 閉じタグを追加
    }else{
        echo    '<div class="box3">
                <div class="status3">GRADUATE</div>
                </div>'; // コメントの修正: 閉じタグを追加
    }
    echo '</div>'; // q_profile の終了タグを追加
    $sql=$pdo->query('select * from question');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="date">',$row['q_date'],'</div>';
    echo '<div class="answer_sum">',$row['answer_sum'],'　回答','</div>';
    echo '</div>'; // q_user の終了タグを修正
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