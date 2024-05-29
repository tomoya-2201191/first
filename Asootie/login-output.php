<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/login-output.css">
        <title>Document</title>
    </head>
    <body>
    <?php session_start(); ?>
<?php require 'db-connect.php'; ?>
<?php require 'header.php'; ?>
<?php
    unset($_SESSION['user']);
        $pdo=new PDO($connect,USER,PASS);
        $sql=$pdo->prepare('select * from user where mail_address=? and pass=?');
        $sql->execute([$_POST['mail_address'],$_POST['pass']]);
    foreach ($sql as $row){
        $_SESSION['user']=[
            'user_id' => $user['user_id'],
            'name' => $user['name'],
            'gender' => $user['gender'],
            'pass' => $user['pass'],
            'mail_address' => $user['mail_address'],
            'status_id' => $user['status_id'],
            'coin' => $user['coin'],
            'upload' => $user['upload'],
            'solution' => $user['solution'],
            'best_answer' => $user['best_answer'],
            'other' => $user['other'],
            'master' => $user['master']
    ];
}
        if(isset($_SESSION['user'])){
            // ログイン処理、成功の場合
            echo 'ログイン完了';
            echo '<form action = "top.php" method = "post">';
            echo '<input type = "submit" value = "トップへ">';
            echo '</form>';
        }else{
            // ログイン処理、失敗の場合
            echo 'ユーザー名、パスワードが一致しません。';
            echo '<form action = "login-input.php" method = "post">';
            echo '<input type = "submit" value = "ログインへ">';
            echo '</form>';
}
?>
    <?php require 'footer.php'; ?>
    </body>
    </html>