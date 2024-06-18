<?php
session_start();;
require 'db-connect.php';
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ユーザーIDの取得
    $user_id = $_SESSION['user_id'];

    // フォームからのデータを取得
    $answer = $_POST['answer'];
    $currentDate = date('Y-m-d'); // 'YYYY-MM-DD' 形式
    $q_id = $_SESSION['q_id'];
    $error_message = '';


    
    // 質問をデータベースに挿入
    $sql_insert = "INSERT INTO answer (a_user_id, a_text, a_date, q_id) 
            VALUES (:user_id, :answer, :currentDate, :q_id)";
    $stmt = $pdo->prepare($sql_insert);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':answer', $answer);
    $stmt->bindParam(':currentDate', $currentDate);
    $stmt->bindParam(':q_id', $q_id);
    $stmt->execute();

    // 質問の現在の回答数を取得
    $answer_update = $pdo->prepare('SELECT answer_sum FROM question WHERE q_id = ?');
    $answer_update->execute([$q_id]);
    $row = $answer_update->fetch(PDO::FETCH_ASSOC);

    // 新しい回答数を計算
    $newAnswerCount = $row['answer_sum'] + 1;

    // 回答数を更新
    $updateAnswerStmt = $pdo->prepare('UPDATE question SET answer_sum = ? WHERE q_id = ?');
    $updateSuccess = $updateAnswerStmt->execute([$newAnswerCount, $q_id]);

    //回答数の更新
    $updateUser = $pdo->prepare('
        UPDATE user
        SET user.other = user.other + 1
        WHERE user_id = ?
        ');
        $updateSuccess = $updateUser->execute([$_SESSION['user_id']]);
    

} else {
    $error_message = "無効なリクエストです。";
    header("Location: situmontoukou.php");
    exit();
}

echo '<div class="contents"><p>回答一覧</p></div>';

echo '<div class="flex">';

echo '<div class="left">';

    $sql = $pdo->prepare('
        SELECT answer.*, user.*
        FROM answer 
        INNER JOIN user ON answer.a_user_id = user.user_id 
        WHERE answer.q_id = ?
    ');
    $sql->execute([$q_id]);
    $results = $sql->fetchAll();
    if (count($results) === 0) {
        echo '<div class="no-answer"><h3>回答はありません</h3></div>';
    } else {
        echo '<div class="no-answer"><h3>回答完了！</h3></div><hr>';
        foreach ($results as $row) {
            echo '<div class="a_user">';
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
            echo '</div>'; // q_user の終了タグを追加
            if ($row['ba_flag'] == 1) {
                echo '<div class="best-img"><img src="img/bestanswer.png" height="140" width="170">';
                echo '<div class="best_text"><p>', $row['a_text'], '</p></div></div>';
            }else{
                echo '<div class="a_text"><p>', $row['a_text'], '</p></div>';
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