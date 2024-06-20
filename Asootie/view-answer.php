<?php
require 'header.php';

// '参考になる'ボタンが押されたときの処理
if (isset($_POST['sankou'])) {
    $a_id = $_POST['a_id'];
    $update_sql = 'UPDATE answer SET reference = reference + 1 WHERE a_id = ?';
    $stmt = $pdo->prepare($update_sql);
    $stmt->execute([$a_id]);
}
?>
<div class="contents"><p>回答一覧</p></div>

<div class="flex">

<div class="left">
    <?php

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
            echo '<div class="a_user">';
            $icon = "dinosaur1.png";
            if ($row['best_answer'] > 20) {
                $icon = "dinosaur4.png";
            } elseif ($row['best_answer'] > 10) {
                $icon = "dinosaur3.png";
            } elseif ($row['best_answer'] > 5) {
                $icon = "dinosaur2.png";
            }
            echo '<img src="img/' . $icon . '" width="90" height="90">';
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
            echo '</div>'; // q_user の終了タグを追加
            if ($row['ba_flag'] == 1) {
                echo '<div class="best-img"><img src="img/bestanswer.png" height="140" width="140">';
                echo '<div class="best_text"><p>', $row['a_text'], '</p></div></div>';
            }else{
                echo '<div class="a_text"><p>', $row['a_text'], '</p></div>';
            }
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="a_id" value="', $row['a_id'], '">';
            echo '<button type="submit" name="sankou" class="sankou">参考になる ', $row['reference'], '</button></form>';

            $sql = $pdo->prepare('
            SELECT *
            FROM question 
            WHERE q_id = ?
        ');
        $sql->execute([$id]);
        $question = $sql->fetch(PDO::FETCH_ASSOC);


        // 質問が存在するか、かつセッションのユーザーが質問者であることをチェック
        if ($question && $question['q_user_id'] == $_SESSION['user_id'] && $question['flag'] == 0) {
            // 回答のIDは `$row['a_id']` と仮定
            echo '<form method="post" action="ba-select.php">';
            echo '<input type="hidden" name="a_user_id" value="',$row['a_user_id'],'">';
            echo '<input type="hidden" name="q_id" value="',$id,'">';
            echo '<button type="submit" name="a_id" value="',$row['a_id'],'"class="ba_btn"><a class="a_color" >ベストアンサーに選ぶ</a></button>';
            echo '</form>';
        }
            echo '<hr>';
        }
    }
    echo '<button class="back" onclick="location.href=\'question.php?id=' . $id . '\'">＜戻る</button>';
    
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
        echo '<li><a class="category-black" href="?id=', $id, '">', $row['category_name'], "</a></li>";
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