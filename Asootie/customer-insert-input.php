<?php
session_start();
require 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/customer-insert-input.css">
    <title>会員登録</title>
</head>
<body>

    <form action="customer-insert-output.php" method="post">
        <img id="logo" src="img/asootie.png" alt="ASOO！知恵袋のロゴ">
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
        <label for="confirm_password">確認用 Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <input type="submit" value="新規登録">
    </form>

    <?php
    if (isset($_SESSION['registration_error'])) {
        echo '<p class="error">' . htmlspecialchars($_SESSION['registration_error']) . '</p>';
        unset($_SESSION['registration_error']);
    }
    ?>

</body>
</html>