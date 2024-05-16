<!DOCTYPE html>
    <html lang="ja">
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
            'user_id'=>$row['user_id'],
            'name'=>$row['name'],
            'gender'=>$row['gender'],
            'pass'=>$row['pass'],
            'mail_address'=>$row['mail_address'],
            'status_id'=>$row['status_id'],
            'coin'=>$row['coin'],
            'upload'=>$row['upload'],
            'solution'=>$row['mail_address'],
            'best_answer'=>$row['best_answer'],
            'other'=>$row['other'],
            'master'=>$_POST['master']
    ];
}
        if(isset($_SESSION['user'])){
            // ログイン処理、成功の場合
            echo '<h1>ログイン完了<h1>',;
            echo '<form action = "top.php" method = "post">';
            echo '<input type = "submit" value = "トップへ">';
            echo '</form>';
        }else{
            // ログイン処理、失敗の場合
            echo 'ユーザー名、パスワードが一致しません。';
            echo '<form action = "login.php" method = "post">';
            echo '<input type = "submit" value = "ログインへ">';
            echo '</form>';
}
?>
    <?php require 'footer.php'; ?>
    </body>
    </html>