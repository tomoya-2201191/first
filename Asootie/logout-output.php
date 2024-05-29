<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/logout-output.css">
    <title>ログアウト</title>
</head>
<body>
            <?php
                //ログアウト処理の実行
                unset($_SESSION['user']);
                echo '<h1> ログアウトしました。</h1>';
                //ログイン画面に遷移する
                echo '<form action = "login-input.php" methods = "post">';
                    echo '<input type = "submit" class="login" value = "ログイン画面へ">';
                echo '</form>';
            ?>
<?php require 'footer.php'; ?>