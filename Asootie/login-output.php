<?php session_start(); ?>
<?php
// データベース接続情報
$servername = "mysql302.phy.lolipop.lan";
$username = "LAA1516825";
$password = "aso1234";
$dbname = "LAA1516825-aso";

try {
    // データベースに接続
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // 入力されたメールアドレスがデータベースに存在するか確認
        $sql = "SELECT * FROM user WHERE mail_address = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['pass'])) {
                // ログイン成功
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                header("Location: login-success.php");
                exit();
            } else {
                // パスワードが一致しない
                $_SESSION['login_error'] = "メールアドレスまたはパスワードが間違っています";
                header("Location: login-input.php");
                exit();
            }
        } else {
            // ユーザーが存在しない
            $_SESSION['login_error'] = "メールアドレスまたはパスワードが間違っています";
            header("Location: login-input.php");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "データベース接続に失敗しました: " . $e->getMessage();
}
?>