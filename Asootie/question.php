<?php
require 'header.php';

// '共感した'ボタンが押されたときの処理
if (isset($_POST['kyokan'])) {
    $q_id = $_POST['q_id'];
    $update_sql = 'UPDATE question SET feel = feel + 1 WHERE q_id = ?';
    $stmt = $pdo->prepare($update_sql);
    $stmt->execute([$q_id]);
}
?>
<div class="contents"><p>質問詳細</p></div>

<div class="flex">

<div class="left">
    <?php
    $pdo = new PDO($connect, USER, PASS);
    $sql = $pdo->prepare('SELECT question.*, user.*
    FROM question
    INNER JOIN user ON question.q_user_id = user.user_id 
    WHERE question.q_id = ?');
    $sql->execute([$_GET['id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="q_user">';
    echo '<img src="img/icon.png" height="80" width="100">';
    echo '<div class="q_profile">', $row['name'], '　さん', '<br>';
    if ($row['status_id'] == 0) {
        echo    '<div class="box1">
                <div class="status1">STUDENT</div>
                </div>';
    } else if ($row['status_id'] == 1) {
        echo    '<div class="box2">
                <div class="status2">TEACHER</div>
                </div>';
    } else {
        echo    '<div class="box3">
                <div class="status3">GRADUATE</div>
                </div>';
    }
    echo '</div>'; // q_profile の終了タグを追加
    $sql = $pdo->prepare('select * from question where q_id=?');
    $sql->execute([$_GET['id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="date">', $row['q_date'], '</div>';
    echo '<div class="answer_sum">', $row['answer_sum'], '　回答', '</div>';
    echo '</div>'; // q_user の終了タグを修正
    $id = $_GET['id'];
    echo '<div class="q_text">', $row['q_text'], '</div>';
    echo '<form method="post" action="">';
    echo '<input type="hidden" name="q_id" value="', $id, '">';
    echo '<button type="submit" name="kyokan" class="kyokan">共感した ', $row['feel'], '</button></form>';
    echo '<div class="coin">';
    echo '<img src="img/coin.png" height="50" width="50">';
    echo '<div class="coin-text">',$row['coin'],"コイン<br>";
    echo '</div></div>';
    echo '<hr><br>';
    echo '<button class="check_answer" onclick="location.href=\'view-answer.php?q_id=' . $id . '\'">回答を見る</button>';
    if($row['flag'] == 0){
        echo '<button class="q_answer" onclick="location.href=\'answer.php?q_id=' . $id . '\'">回答をする</button>';
    }else{
        echo '<button class="q_answer">解決済み！</a></button>';
    }
    
    ?>
</div>

<div class="right">
    <?php
    echo '<div class="category">';
    $sql = $pdo->query('select * from category');
    echo '<br>　カテゴリ一覧';
    echo '<hr>';
    echo '<ul>';
    foreach ($sql as $row) {
        $id = $row['category_id'];
        echo '<li><a class="category-black" href="?id=', $id, '">', $row['category_name'], "</a></li>";
        echo '<br>';
    }
    echo "</ul>";
    echo '<hr>';
    ?>
</div>

</div>
<?php
require 'footer.php';
?>
