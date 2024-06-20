<?php
require 'header.php';

?>
<div class="contents"><p>ベストアンサー選択</p></div>

<div class="flex">

<div class="left">
    <?php

    
    // ベストアンサーフラッグを更新
    $updateAnswer = $pdo->prepare('
    UPDATE answer 
    SET ba_flag = 1 
    WHERE a_id = ?
    ');
    $updateSuccess1 = $updateAnswer->execute([$_POST['a_id']]);

    //解決済みフラッグを更新
    $updateQuestion = $pdo->prepare('
    UPDATE question 
    SET flag = 1 
    WHERE q_id = ?
    ');
    $updateSuccess2 = $updateQuestion->execute([$_POST['q_id']]);

    //解決済み質問数の更新(投稿者)
    $update = $pdo->prepare('
        UPDATE user
        INNER JOIN question ON user.user_id = question.q_user_id
        SET user.solution = user.solution + 1
        WHERE question.q_id = ?
    ');
    $updateQuestionUser = $update->execute([$_POST['q_id']]);

    // 質問情報の取得
    $question = $pdo->prepare('SELECT * FROM question WHERE q_id = ?');
    $question->execute([$_POST['q_id']]);
    $questionRow = $question->fetch(PDO::FETCH_ASSOC);
    $getCoin = $questionRow['coin'];

    $user = $pdo->prepare('SELECT * FROM user WHERE user_id = ?');
    $user->execute([$_POST['a_user_id']]);
    $userRow = $user->fetch(PDO::FETCH_ASSOC);
    $updateCoin = $userRow['coin'] + $getCoin;

    //ベストアンサー数の更新(回答者)
    if($userRow['other'] == 0){
        $updateUser = $pdo->prepare('
        UPDATE user
        INNER JOIN answer ON user.user_id = answer.a_user_id
        SET user.coin = ?, user.best_answer = user.best_answer + 1
        WHERE answer.a_id = ?
        ');
        $updateSuccess3 = $updateUser->execute([$updateCoin, $_POST['a_id']]);
    }else{
        $updateUser = $pdo->prepare('
        UPDATE user
        INNER JOIN answer ON user.user_id = answer.a_user_id
        SET user.coin = ?, user.best_answer = user.best_answer + 1, user.other = user.other - 1
        WHERE answer.a_id = ?
        ');
        $updateSuccess3 = $updateUser->execute([$updateCoin, $_POST['a_id']]);
    }
    

    $sql = $pdo->prepare('
        SELECT answer.*, user.*
        FROM answer 
        INNER JOIN user ON answer.a_user_id = user.user_id 
        WHERE answer.q_id = ?
    ');
    $id = $_POST['q_id'];
    $sql->execute([$id]);
    $results = $sql->fetchAll();
    echo '<div class="no-answer"><h3>ベストアンサーに選択しました！</h3></div><hr>';
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
            echo '<button type="submit" name="sankou" class="sankou">参考になる ', $row['reference'], '</button></form><hr>';

            /*$sql = $pdo->prepare('
            SELECT *
            FROM question 
            WHERE q_id = ?
        ');
        $sql->execute([$id]);
        $question = $sql->fetch(PDO::FETCH_ASSOC);*/
        }
        echo '<button class="back" onclick="location.href=\'question.php?id=' . $id . '\'">＜戻る</button>';?>
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