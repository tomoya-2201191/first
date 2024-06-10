<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-input.css">
    <title>ログインフォーム</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <form action="login-output.php" method="post">
    <img id="logo" src="img/asootie.png" alt="ASOO！知恵袋のロゴ">
        <label for="email">E-mail Address:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
            unset($_SESSION['login_error']); // エラーメッセージを消去
        }
        ?>
        <input type="submit" value="ログイン">
        <a href="customer-insert-input.php" class="button">新規登録</a>
    </form>
</body>
</html>