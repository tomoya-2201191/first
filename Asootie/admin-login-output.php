<?php
session_start();
require 'db-connect.php';

if(isset($_POST['login'])){
    $error_message = "";
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = $pdo->prepare('select * from admin where mail_address = ?');
    $sql->execute([$email]);
    $row = $sql->fetch();

    if($email !== @$row['mail_address']){
        $error_message = "※メールアドレスが違います";
    }else if($pass !== $row['pass']){
        $error_message = "※パスワードが違います";
    }else{
        $login_success_url = "admin-top.php";
        header("Location: {$login_success_url}");
        $_SESSION['admin']=[
            'id'=>$row['admin_id'],
            'pass'=>$row['pass'],
            'email'=>$row['mail_address']
        ];
        exit;
}
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <!--link rel="stylesheet" href="css/style.css"> -->
    <!-- <link rel="stylesheet" href="css/fade.css">  -->
</head>
<body>
    <div class="back-white">
        <div class="admin-img">
            <img src="img/king-logo.png" width="150" height="150">
        </div>

        <?php
            if(empty($error_message)){
                echo '<p class="complete">ログイン完了</p>
                <form action="admin-top.php" method="post">
                    <button type="submit" class="login-btn">トップへ</button>
                </form>';
            }else{
                echo '<p class="complete">'.$error_message.'</p>
                <form action="admin-login.php" method="post">
                    <button type="submit" class="login-btn">ログイン画面へ</button>
                </form>';
            }
        ?>

        
    </div>
</body>
<?php
require 'footer.php';
?>