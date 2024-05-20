<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-output.css">
    <title>ログイン</title>
</head>
<body>
    <?php session_start(); ?>
    <?php require 'db-connect.php'; ?>
    <?php require 'header.php'; ?>
    <?php
        // セッション情報を初期化
        unset($_SESSION['user']);

        // データベースに接続
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // ユーザーをメールアドレスで検索
            $sql = $pdo->prepare('SELECT * FROM user WHERE mail_address = ?');
            $sql->execute([$_POST['mail_address']]);
            $user = $sql->fetch();

            // ユーザーが存在し、パスワードが一致する場合
            if ($user && password_verify($_POST['pass'], $user['pass'])) {
                // セッションにユーザー情報を保存
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'name' => $user['name'],
                    'gender' => $user['gender'],
                    'pass' => $user['pass'],
                    'mail_address' => $user['mail_address'],
                    'status_id' => $user['status_id'],
                    'coin' => $user['coin'],
                    'upload' => $user['upload'],
                    'solution' => $user['solution'],
                    'best_answer' => $user['best_answer'],
                    'other' => $user['other'],
                    'master' => $user['master']
                ];

                // ログイン成功
                echo '<h1>ログイン完了</h1>';
                echo '<form action="top.php" method="post">';
                echo '<input type="submit" value="トップへ">';
                echo '</form>';
            } else {
                // ログイン失敗
                echo '<p>メールアドレスまたはパスワードが一致しません。</p>';
                echo '<form action="login-input.php" method="post">';
                echo '<input type="submit" value="ログインへ">';
                echo '</form>';
            }
        } catch (PDOException $e) {
            echo '<p>データベースエラー: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    ?>
    <?php require 'footer.php'; ?>
</body>
</html>