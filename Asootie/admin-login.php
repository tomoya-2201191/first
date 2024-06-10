<?php
session_start();
require 'db-connect.php';

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <!--link rel="stylesheet" href="css/style.css"> -->
    <!-- <link rel="stylesheet" href="css/fade.css">  -->
</head>
<body>
    <div class="back-white">
        <div class="admin-img">
            <img src="img/king-logo.png" width="150" height="150">
        </div>
        <form action="admin-login-output.php" method="post">
            <input type="text" class="textbox" name="email" placeholder="Email Address" required>
            <div class="under"></div>
            <input type="text" class="textbox" name="password" placeholder="Password" required>
            <div class="under"></div>
            <button type="submit" name="login" class="login-btn">ログイン</button>
        </form>
    </div>
</body>
<?php
require 'footer.php';
?>