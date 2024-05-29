<?php session_start(); ?>
<?php require 'db-connect.php'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-input.css">
    <title>ログイン</title>
</head>
<body>
    <h1>ASOスポーツ用品サイト</h1>

    <!-- ログインフォーム -->
    <form action="login-input.php" method="post">
        <div class="form-group">
            <label for="mail_address" class="loginname">メールアドレス</label>
            <input type="text" id="mail_address" name="mail_address" required><br>
        </div>
        <div class="form-group">
            <label for="pass" class="passname">パスワード</label>
            <input type="password" id="pass" name="pass" required><br>
        </div>
        <input type="submit" class="login" value="ログイン">
    </form>

    <!-- 新規会員登録フォーム -->
    <form action="customer-insert-input.php" method="post">
        <p class="hajimete">初めての方はこちらから</p>
        <input type="submit" class="newmember" value="新規会員登録">
    </form>

    <?php
        if(!empty($_POST['mail_address'])){
            $pdo=new PDO($connect, USER, PASS);
            $sql=$pdo->prepare('select * from user where mail_address=?');
            $sql->execute([$_POST['mail_address']]);
            $user = $sql->fetch(); // ユーザー情報を取得

            if(empty($user)){
                echo '<p class="error">メールアドレスまたはパスワードが違います。</p>';
            } else {
                if(password_verify($_POST['pass'], $user['pass'])) {
                    $_SESSION['user'] = $user; // ユーザー情報をセッションに保存
                    echo '<script>location.href="top.php";</script>';
                    exit;
                } else {
                    echo '<p class="error">メールアドレスまたはパスワードが違います。</p>';
                }
            }
        }
    ?>

<?php require 'footer.php'; ?>
</body>
</html>