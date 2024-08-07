<?php
require 'header.php';
?>

<?php


    // POSTリクエストを処理
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // ユーザーIDの取得
        $user_id = $_SESSION['user_id'];

        // フォームからのデータを取得
        $question = $_POST['question'];
        $category = $_POST['category'];
        $coins = $_POST['coins'];
        $error_message = '';

        // 入力データのバリデーション
        if (empty($question) || empty($category) || $coins < 0) {
            $error_message = "すべての項目を正しく入力してください。";
            header("Location: situmontoukou.php"); // フォームページにリダイレクト
            exit();
        }

        $currentDate = date('Y-m-d'); // 'YYYY-MM-DD' 形式
        // 質問をデータベースに挿入
        $sql = "INSERT INTO question (q_user_id, q_text, q_date, category_id, coin) 
                VALUES (:user_id, :question, :currentDate, :category, :coins)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':currentDate', $currentDate);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':coins', $coins);
        $stmt->execute();

        // コインの更新
        $sql = $pdo->prepare('select * from user where user_id = ?');
        $sql->execute([$user_id]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        $newCoinBalance = $row['coin'] - $coins;
        $updateCoinStmt = $pdo->prepare('UPDATE user SET coin = ? WHERE user_id = ?');
        $updateCoinStmt->execute([$newCoinBalance, $user_id]);

        //質問投稿数の更新
        $updateUser = $pdo->prepare('UPDATE user SET upload = upload + 1 WHERE user_id = ?');
        $updateUser->execute([$user_id]);

        $success_message = "質問が正常に投稿されました。";
        /*header("Location: situmontoukou-output.php"); // 成功ページにリダイレクト
        exit();*/

    } else {
        $error_message = "無効なリクエストです。";
        header("Location: situmontoukou.php");
        exit();
    }
?>

<div class="contents">
    <p>質問投稿完了</p>
</div>

<div class="flex">

    <div class="left">

        <?php
           echo '<div class="no-answer"><h3>',$success_message,'</h3></div><hr>';
           $pdo = new PDO($connect, USER, PASS);
           $sql = $pdo->prepare('SELECT question.*, user.*, question.coin AS question_coin, user.coin AS user_coin
           FROM question
           INNER JOIN user ON question.q_user_id = user.user_id 
           ORDER BY question.q_id DESC
           LIMIT 1');
            $sql->execute([]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            echo '<div class="q_user">';
            $icon = "dinosaur1.png";
            if ($row['best_answer'] > 20) {
                $icon = "dinosaur4.png";
            } elseif ($row['best_answer'] > 10) {
                $icon = "dinosaur3.png";
            } elseif ($row['best_answer'] > 5) {
                $icon = "dinosaur2.png";
            }
            echo '<img src="img/' . $icon . '" width="90" height="90">';
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
            
            echo '<div class="date">', $row['q_date'], '</div>';
            echo '<div class="answer_sum">', $row['answer_sum'], '　回答', '</div>';
            echo '</div>'; // q_user の終了タグを修正
            echo '<div class="q_text">', $row['q_text'], '</div>';
            echo '<div class="coin">';
            echo '<img src="img/coin.png" height="50" width="50">';
            echo '<br>';
            echo '<div class="coin-text">',$row['question_coin'],"コイン<br></div></div>";
            echo '<button class="back" onclick="location.href=\'top.php\'">トップへ戻る</button>';
                ?>

    </div>

    <div class="right">
            <?php
            $sql = $pdo->query('SELECT * FROM category');
            echo '<div class="category">';
            echo '<br>', '　カテゴリ一覧';
            echo '</div>';
            echo '<hr>';

            echo '<ul class="category_box">';
            foreach ($sql as $row) {
                $id = $row['category_id'];
                echo '<li><a class="category-black" href="?id=', $id, '">', htmlspecialchars($row['category_name']), "</a></li>";
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
