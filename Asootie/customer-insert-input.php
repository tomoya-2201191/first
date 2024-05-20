<?php session_start(); ?>
<?php require 'db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/customer-insert-input.css">
    <title>会員登録</title>
</head>
<body>
    <?php
        echo '<h1>新規登録画面</h1>';
        //ユーザー登録に遷移する
        echo '<form action = "customer-insert-input.php" method = "post">';
            echo '<table>';
                //requiredで未入力項目の摘出,ユーザー情報の登録
                echo '<tr><td class = "form-label">ユーザー名</td><td>';
                echo '<input type="text" required name="member_mei" class = "form-input" value="',$_POST['member_mei'],'">';
                echo '</td></tr>';
                echo '<tr><td class = "form-label">住所</td><td>';
                echo '<input type="text" required name="member_stay" class = "form-input" value="',$_POST['member_stay'],'">';
                echo '</td></tr>';
                echo '<tr><td class = "form-label">電話番号（ハイフンなし）</td><td>';
                echo '<input type="text" required name="member_fon" class = "form-input" value="',$_POST['member_fon'],'">';
                echo '</td></tr>';
                echo '<tr><td class = "form-label">パスワード</td><td>';
                echo '<input type="password" required name="member_pass" class = "form-input" value="',$_POST['member_pass'],'">';
                echo '</td></tr>';
            echo '</table>';
            echo '<input type = "submit" class = "submit-btn" value = "登録">';
        echo '</form>';

        //form受け取り後処理
        if(!empty($_POST['member_mei'])){
            $pdo=new PDO($connect,USER,PASS);
            //ユーザー名の確認
            $sql=$pdo->prepare('select * from Member where member_mei=?');
            $sql->execute([$_POST['member_mei']]);
            if(empty($sql->fetchAll())){
                //電話番号の確認1
                if(preg_match( '/^0[0-9]{9,10}\z/', $_POST['member_fon'] )){
                    //電話番号の確認2
                    $sql=$pdo->prepare('select * from Member where member_fon=?');
                    $sql->execute([$_POST['member_fon']]);
                    if(empty($sql->fetchAll())){
                        $sql=$pdo->prepare('insert into Member values(null,?,?,?,?)');
                        $sql->execute([
                            $_POST['member_mei'],$_POST['member_stay'],
                            $_POST['member_fon'],password_hash($_POST['member_pass'],PASSWORD_DEFAULT)
                        ]);
                        echo <<<EOF
                        <script>
                            location.href='customer-insert-output.php';
                        </script>
                        EOF;
                    }else{
                        //エラー処理
                        echo '<p>この電話番号は既に登録されてあります。</p>';
                    }
                }else{
                    //エラー処理
                    echo '<p>電話番号を正しく入力してください。</p>';
                }
            }else{
                //エラー処理
                echo '<p>このユーザー名は既に登録されてあります。</p>';
            }
        }
        //ログイン画面に遷移する
        echo '<form action = "login-input.php" method = "post">';
            echo '<input type = "submit" class = "back-btn" value = "戻る">';
        echo '</form>';
    ?>
<?php require 'footer.php'; ?>