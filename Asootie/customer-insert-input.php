<?php session_start(); ?>
<?php require 'db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/customer-insert-input.css">
    <title>会員登録</title>
</head>
<body>
<h1>新規登録フォーム</h1>
    <form action="customer-insert-output.php" method="post">
        <label for="name">名前:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="gender">性別:</label><br>
        <select id="gender" name="gender" required>
            <option value="男">男</option>
            <option value="女">女</option>
        </select><br><br>
        <label for="email">E-mail Address:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="新規登録">
    </form>
</body>
</html>
<?php require 'footer.php'; ?>