<?php
session_start();

// ユーザーがログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header("Location: login-input.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #4CAF50;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>ログイン完了</h1>
    <p><?php echo htmlspecialchars($_SESSION['name']); ?>さん、ログインが成功しました。</p>
    <a href="top.php" class="button">トップへ</a>
</body>
</html>