<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="a1"></div>

<div class="flex">

<div class="left">
    <?php
    // データベース接続のためのコード
    // $pdo = new PDO('mysql:host=localhost;dbname=your_database_name;charset=utf8', 'username', 'password');

    $sql = $pdo->prepare('
        SELECT answer.*, user.*
        FROM answer 
        INNER JOIN user ON answer.a_user_id = user.user_id 
        WHERE answer.q_id = ?
    ');
    $id = $_GET['q_id'];
    $sql->execute([$id]);
    $results = $sql->fetchAll();
    if (count($results) === 0) {
        echo '<div class="no-answer"><h3>回答はありません</h3></div>';
    } else {
        foreach ($results as $row) {
            echo '<div class="q_user">';
            echo '<img src="img/icon.png" height="80" width="110">';
            echo '<div class="q_profile">', $row['name'], ' さん<br>';
            if ($row['status_id'] == 0) {
                echo '<div class="box1">
                        <div class="status1">STUDENT</div>
                      </div>';
            } elseif ($row['status_id'] == 1) {
                echo '<div class="box2">
                        <div class="status2">TEACHER</div>
                      </div>';
            } else {
                echo '<div class="box3">
                        <div class="status3">GRADUATE</div>
                      </div>';
            }
            echo '</div>'; // q_profile の終了タグを追加
            echo '<div class="date">', $row['a_date'], '</div><br>';
            if ($row['ba_flag'] == 1) {
                echo '<div class="best-img"><img src="img/bestanswer.png" height="120" width="150"></div>';
            }
            echo '</div>'; // q_user の終了タグを追加
            echo '<div class="a_text"><p>', $row['a_text'], '</p></div>';
            echo '<hr>';
        }
    }
    echo '<button class="back"><a href="question.php?id=' . $id . '">戻る＞</a></button>';
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