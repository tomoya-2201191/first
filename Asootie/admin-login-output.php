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
        <p class="complete">ログイン完了</p>
        <form action="#" method="post">
            <button type="submit" class="login-btn">トップへ</button>
        </form>
    </div>
</body>
<?php
require 'footer.php';
?>