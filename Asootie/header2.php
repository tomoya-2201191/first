<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db-connect.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asoo!知恵袋</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header-top.css">
    <link rel="stylesheet" href="css/situmonnkaitou.css">
    <link rel="stylesheet" href="css/answer.css">
    <!-- <link rel="stylesheet" href="css/fade.css">  -->
</head>

<body>
    <div class="header-top3"></div>

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
        <!-- <div class="search_box">
            <form method="get" action="#" class="search">
                <div class="searchForm">
                    <input type="text" class="searchForm-input" placeholder="Q&Aを探す">
                    <button type="submit" class="searchForm-submit"></button>
                </div>
            </form>
        </div> -->

        <form action="#" class="search-form-1">
            <label>
                <input type="text" placeholder="キーワードを入力">
            </label>
            <button type="submit" aria-label="検索"></button>
        </form>

        <div class="icon">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<a href="user-profile.php?user_id=' . $_SESSION['user_id'] . '">';
                echo '<img src="img/icon.png" alt="ユーザーアイコン">';
                echo '</a>';
            } else {
                echo '<a href="login.php">';
                echo '<img src="img/icon.png" alt="ユーザーアイコン">';
                echo '</a>';
            }
            ?>
        </div>
    </header>

    <div class="question">
        <a class="questionn" href="situmontoukou.php">質問・相談はこちら</a>
    </div>
</body>
</html>
