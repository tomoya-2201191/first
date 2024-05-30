<?php
session_start();;
require 'db-connect.php';
require 'header.php';

// データベース接続
//$conn = new mysqli($servername, $username, $password, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// フォームが送信された場合の処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $question = htmlspecialchars($_POST["question"]);
    $category = htmlspecialchars($_POST["category"]);
    $coins = intval($_POST["coins"]);

    // データベースに質問を保存
    $sql = "INSERT INTO questions (username, question, category, coins) VALUES ('$username', '$question', '$category', $coins)";
    if ($conn->query($sql) === TRUE) {
        echo "新しい質問が投稿されました";
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>質問投稿 - AsoO! 知恵袋</title>
    <link rel="stylesheet" href="css/situmonnkaitou.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button.cancel {
            background-color: #DC3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>質問投稿</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">ユーザー名</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="question">質問内容</label>
                <textarea id="question" name="question" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">カテゴリを選択してください</label>
                <select id="category" name="category" required>
                    <option value="業界">業界</option>
                    <option value="職種">職種</option>
                    <option value="自己分析">自己分析</option>
                    <option value="面接対策">面接対策</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <div class="form-group">
                <label for="coins">ベストアンサーのお礼（コイン）</label>
                <input type="number" id="coins" name="coins" value="100" required>
            </div>
            <div class="form-group">
                <button type="submit">投稿</button>
                <button type="button" class="cancel" onclick="window.location.href='/'">キャンセル</button>
            </div>
        </form>
    </div>
</body>
</html>