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
$sql = "SELECT name, gender, mail_address FROM user WHERE user_id = :user_id";
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
</head>
<body>
    <form action="customer-update-output.php" method="post">
        <img id="logo" src="img/asootie.png" alt="ASOO！知恵袋のロゴ">
        <label for="name">名前:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>
        <label for="gender">性別:</label><br>
        <select id="gender" name="gender" required>
            <option value="男" <?php if ($user['gender'] == '男') echo 'selected'; ?>>男</option>
            <option value="女" <?php if ($user['gender'] == '女') echo 'selected'; ?>>女</option>
        </select><br><br>
        <label for="email">E-mail Address:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['mail_address']); ?>" required><br><br>
        <label for="password">Password (新しいパスワードを入力しない場合は空のままにしてください):</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="更新">
    </form>

    <?php
    if (isset($_SESSION['update_error'])) {
        echo '<p class="error">' . htmlspecialchars($_SESSION['update_error']) . '</p>';
        unset($_SESSION['update_error']);
    }
    ?>

</body>
</html>