<?php
session_start();
require 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asoo!知恵袋</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/5-6.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link rel="stylesheet" href="css/header-top.css">
    <link rel="stylesheet" href="css/situmontoukou.css">
    <link rel="stylesheet" href="css/answer.css">
    <!-- <link rel="stylesheet" href="css/fade.css"> -->
</head>

<body>
    <div class="header-top"></div>

    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <header>
        <div class="logo">
            <a href="top.php">
                <img src="img/asootie.png" alt="ロゴ">
            </a>
        </div>

        <form method="post" action="search.php" class="search-form-1">
            <label>
                <input type="text" name="keyword" placeholder="キーワードを入力">
            </label>
            <button type="submit" aria-label="検索"></button>
        </form>

        <div class="icon">
            <a href="profile.php">
                <?php
                $sql = $pdo -> prepare('select * from user where user_id =?');
                $sql -> execute([$_SESSION['user_id']]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                // ユーザーのbest_answerに応じたアイコン画像の選択
                $icon = "dinosaur1.png";
                if ($row['best_answer'] > 20) {
                    $icon = "dinosaur4.png";
                } elseif ($row['best_answer'] > 10) {
                    $icon = "dinosaur3.png";
                } elseif ($row['best_answer'] > 5) {
                    $icon = "dinosaur2.png";
                }
                echo '<img src="img/' . $icon . '">';
                ?>
            </a>
        </div>
    </header>

    <!-- ↓桜 -->
    <div id="particles-js"></div>
    <div id="wrapper">
        <div class="question">
            <a class="questionn" href="situmontoukou.php">質問・相談はこちら</a>
        </div>