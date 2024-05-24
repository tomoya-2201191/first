<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインフォーム</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <h1>ようこそ、<?php echo htmlspecialchars($_SESSION['name']); ?>さん</h1>
    <?php else: ?>
        <h1>ログインフォーム</h1>
        <form action="login-output.php" method="post">
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
        </form>
        <br>
        <a href="customer-insert-input.php">新規登録</a>
    <?php endif; ?>
</body>
</html>