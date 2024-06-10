<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($password) && ($password !== $confirm_password)) {
        $_SESSION['update_error'] = "パスワードが一致しません。";
        header("Location: customer-update-input.php");
        exit();
    }

    // SQL文の構築
    $sql = "UPDATE user SET name = :name, gender = :gender, mail_address = :email";
    
    // パスワードが入力されている場合、パスワードも更新する
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", pass = :password";
    }

    $sql .= " WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);

    // パラメータをバインド
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    if (!empty($password)) {
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    }

    try {
        // 実行
        $stmt->execute();
        $_SESSION['update_success'] = "会員情報が更新されました。";
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['update_error'] = "更新に失敗しました: " . $e->getMessage();
        header("Location: customer-update-input.php");
        exit();
    }
}