<?php
session_start();
require 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // パスワードの一致を確認
    if ($password !== $confirm_password) {
        $_SESSION['registration_error'] = "パスワードが一致しません。";
        header("Location: customer-insert-input.php");
        exit();
    }

    // パスワードをハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // SQL文を準備
        $sql = "INSERT INTO user (name, gender, mail_address, pass) VALUES (:name, :gender, :email, :password)";
        $stmt = $pdo->prepare($sql);

        // パラメータをバインド
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        // 実行
        $stmt->execute();

        // 登録成功
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['name'] = $name;
        header("Location: registration-complete.php");
        exit();

    } catch (PDOException $e) {
        echo "データベース接続に失敗しました: " . $e->getMessage();
    }
}
?>