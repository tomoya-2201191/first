<?php
session_start();;
require 'db-connect.php';
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
        $sql = $pdo->prepare('select * from user where user_id=?');
        $sql->execute([$user_id]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        $newCoinBalance = $row['coin'] - $coins;
        $updateCoinStmt = $pdo->prepare('UPDATE user SET coin = ? WHERE user_id = ?');
        $updateCoinStmt->execute([$newCoinBalance, $user_id]);

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
        ?>

    </div>

    <div class="right">

        <?php

        echo '<div class="category">';
        $sql = $pdo->query('SELECT * FROM category');
        echo '<br>', '　カテゴリ一覧';
        echo '<hr>';
        echo '<ul>';
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
</div>

<?php
require 'footer.php';
?>
