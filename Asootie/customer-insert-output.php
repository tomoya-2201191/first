<?php
session_start();
require 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $status_id = $_POST['status_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // パスワードの一致を確認
    if ($password !== $confirm_password) {
        $_SESSION['registration_error']['general'] = "パスワードが一致しません。";
        header("Location: customer-insert-input.php");
        exit();
    }

    try {
        // メールアドレスの重複チェック
        $sql = "SELECT COUNT(*) FROM user WHERE mail_address = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['registration_error']['email'] = "すでに登録されているメールアドレスです。";
            header("Location: customer-insert-input.php");
            exit();
        }

        // パスワードをハッシュ化
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL文を準備
        $sql = "INSERT INTO user (name, gender, mail_address, pass, status_id) VALUES (:name, :gender, :email, :password, :status_id)";
        $stmt = $pdo->prepare($sql);

        // パラメータをバインド
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':status_id', $status_id);

        // 実行
        $stmt->execute();

        // 登録成功
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['name'] = $name;
        header("Location: registration-complete.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['registration_error']['general'] = "データベース接続に失敗しました: " . $e->getMessage();
        header("Location: customer-insert-input.php");
        exit();
    }
}
?>