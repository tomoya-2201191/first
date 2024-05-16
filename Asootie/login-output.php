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
    unset($_SESSION['Member']);
        $pdo=new PDO($connect,USER,PASS);
        $sql=$pdo->prepare('select * from Member where member_mei=? and member_pass=?');
        $sql->execute([$_POST['member_mei'],$_POST['member_pass']]);
    foreach ($sql as $row){
        $_SESSION['Member']=[
                'member_number'=>$row['member_number'],'member_mei'=>$row['member_mei'],
                'member_stay'=>$row['member_stay'],'member_fon'=>$row['member_fon'],
                'member_pass'=>$row['member_pass']
    ];
}
        if(isset($_SESSION['Member'])){
            // ログイン処理、成功の場合
            echo 'いらっしゃいませ、',$_SESSION['Member']['member_mei'],'さん。';
            echo '<form action = "product.php" method = "post">';
            echo '<input type = "submit" value = "商品画面へ">';
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