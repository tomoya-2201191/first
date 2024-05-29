<?php session_start(); ?>
<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/customer-insert-output.css">
    <title>会員登録</title>
</head>
<body>
    <h1>会員登録完了画面</h1>
    会員登録が完了しました。
    <form action = "login-input.php" method = "post">
        <input type = "submit" class = "back-btn" value = "ログイン画面へ">
    </form>
<?php require 'footer.php'; ?>