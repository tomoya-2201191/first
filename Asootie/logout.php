<?php
session_start();
if (isset($_POST['logout'])) {
    // ログアウト処理の実行
    unset($_SESSION['user']);
    // ログイン画面にリダイレクト
    header("Location: login-input.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/logout.css">
    <title>ログアウト</title>
</head>
<body>
    <div class="container">
        <!-- ログアウトボタンでログアウト処理をして login-input.php へ遷移 -->
        <form action="" method="post">
            <h1>ログアウトしますか？</h1>
            <input type="submit" class="out" value="ログアウト" name="logout">
        </form>
        <!-- 戻るボタンで profile.php へ遷移 -->
        <form action="profile.php" method="post">
            <input type="submit" class="back" value="戻る">
        </form>
    </div>
    <?php require 'footer.php'; ?>
</body>
</html>