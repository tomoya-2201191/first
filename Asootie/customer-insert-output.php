<?php
// データベース接続情報
$servername = "mysql302.phy.lolipop.lan";
$username = "LAA1516825";
$password = "aso1234";
$dbname = "LAA1516825-aso";

try {
    // データベースに接続
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // エラーモードを例外に設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // ユーザーをデータベースに挿入
        $sql = "INSERT INTO user (name, gender, pass, mail_address) VALUES (:name, :gender, :pass, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':pass', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // 登録完了画面にリダイレクト
        header("Location: registration-complete.php");
        exit();
    }
} catch (PDOException $e) {
    echo "データベース接続に失敗しました: " . $e->getMessage();
}
?>