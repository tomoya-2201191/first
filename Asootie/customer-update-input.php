<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db-connect.php';

// ユーザーがログインしていることを確認
if (!isset($_SESSION['user_id'])) {
    header("Location: login-input.php");
    exit();
}

// ユーザーの現在の情報を取得
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, gender, mail_address, status_id FROM user WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "ユーザー情報が見つかりません。";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/customer-insert-input.css">
    <title>会員情報更新</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <form action="customer-update-output.php" method="post">
        <img id="logo" src="img/asootie.png" alt="ASOO！知恵袋のロゴ">
        <label for="name">名前:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>
        <label for="gender">性別:</label>
        <select id="gender" name="gender" required>
            <option value="男" <?php if ($user['gender'] == '男') echo 'selected'; ?>>男</option>
            <option value="女" <?php if ($user['gender'] == '女') echo 'selected'; ?>>女</option>
        </select><br><br>
        <label for="status_id">ステータス:</label>
        <select id="status_id" name="status_id" required>
            <option value="0" <?php if ($user['status_id'] == '0') echo 'selected'; ?>>在校生</option>
            <option value="1" <?php if ($user['status_id'] == '1') echo 'selected'; ?>>教師</option>
            <option value="2" <?php if ($user['status_id'] == '2') echo 'selected'; ?>>卒業生</option>
        </select><br><br>
        <label for="email">E-mail Address:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['mail_address']); ?>" required><br>
        <?php
        if (isset($_SESSION['update_error']) && !empty($_SESSION['update_error']['email'])) {
            echo '<p class="error">' . htmlspecialchars($_SESSION['update_error']['email']) . '</p>';
            unset($_SESSION['update_error']['email']);
        }
        ?><br>
        <label for="password">新しいパスワード (空の場合は変更されません):</label>
        <input type="password" id="password" name="password"><br><br>
        <label for="confirm_password">パスワード確認:</label>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>
        <input type="submit" value="更新">
    </form>

    <?php
    if (isset($_SESSION['update_error']) && !empty($_SESSION['update_error']['general'])) {
        echo '<p class="error">' . htmlspecialchars($_SESSION['update_error']['general']) . '</p>';
        unset($_SESSION['update_error']['general']);
    }
    ?>

    <script>
        document.querySelector("form").addEventListener("submit", function (event) {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                event.preventDefault();
                alert("パスワードが一致しません。");
            }
        });
    </script>
</body>
</html>