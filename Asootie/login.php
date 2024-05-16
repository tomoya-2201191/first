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
    <form action="login-input.php" method="post">
        <div class="form-group">
            <label for="member_mei" class="loginname">メールアドレス</label>
            <input type="text" id="member_mei" name="member_mei" required><br>
        </div>
        <div class="form-group">
            <label for="member_pass" class="passname">パスワード</label>
            <input type="password" id="member_pass" name="member_pass" required><br>
        </div>
        <input type="submit" class="login" value="ログイン">
    </form>
    <form action="customer-insert-input.php" method="post">
        <p class="hajimete">初めての方はこちらから</p>
        <input type="submit" class="newmember" value="新規会員登録">
    </form>

    <?php
        if(!empty($_POST['member_mei'])){
            $pdo=new PDO($connect, USER, PASS);
            $sql=$pdo->prepare('select * from Member where member_mei=?');
            $sql->execute([$_POST['member_mei']]);
            if(empty($sql->fetchAll())){
                echo '<p class = "erorr">ログイン名またはパスワードが違います。</p>';
            }else{
                $sql=$pdo->prepare('select * from Member where member_mei=?');
                $sql->execute([$_POST['member_mei']]);
                foreach($sql as $row){
                    if(password_verify($_POST['member_pass'],$row['member_pass']) == true){
                        $_SESSION['Member']=[
                            'member_number'=>$row['member_number'],
                            'member_mei'=>$row['member_mei'],
                            'member_stay'=>$row['member_stay'],
                            'member_fon'=>$row['member_fon'],
                            'member_pass'=>$_POST['member_pass']
                        ];
                        
                        echo <<<EOF
                        <script>
                            location.href='product.php';
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