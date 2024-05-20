<?php session_start(); ?>
<?php require 'db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-input.css">
    <style>
        /* Add this style to increase the size of the text boxes */
        input[type="text"], input[type="password"] {
            width: 300px; /* Adjust the width as needed */
            padding: 8px; /* Adjust the padding as needed */
        }
    </style>
    <title>ログイン</title>
</head>
<body>
    <h1>ASO知恵袋</h1>
    <!-- ログイン画面に遷移するフォームなど... -->
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="mail_address" class="loginname">メールアドレス</label>
            <input type="text" id="mail_address" name="mail-address" required><br>
        </div>
        <div class="form-group">
            <label for="pass" class="passname">パスワード</label>
            <input type="password" id="pass" name="pass" required><br>
        </div>
        <input type="submit" class="login" value="ログイン">
    </form>
    <form action="customer-insert-input.php" method="post">
        <input type="submit" class="newmember" value="新規登録">
    </form>

    <?php
        if(!empty($_POST['mail_address'])){
            $pdo=new PDO($connect, USER, PASS);
            $sql=$pdo->prepare('select * from user where mail_address=?');
            $sql->execute([$_POST['mail_address']]);
            if(empty($sql->fetchAll())){
                echo '<p class = "erorr">メールアドレスまたはパスワードが違います。</p>';
            }else{
                $sql=$pdo->prepare('select * from user where mail_address=?');
                $sql->execute([$_POST['mail_address']]);
                foreach($sql as $row){
                    if(password_verify($_POST['pass'],$row['pass']) == true){
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
                        
                        echo <<<EOF
                        <script>
                            location.href='top.php';
                        </script>
                        EOF;
    
                    }else{
                        echo '<p class = "erorr">ログイン名またはパスワードが違います。</p>';
                    }
                }
            }
        }
    ?>

<?php require 'footer.php'; ?>