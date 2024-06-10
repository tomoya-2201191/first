<?php
session_start();
require 'db-connect.php';

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者トップ</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <!--link rel="stylesheet" href="css/style.css"> -->
    <!-- <link rel="stylesheet" href="css/fade.css">  -->
</head>
<body>
<div class="header-top"></div>

<div class="header">

    <div class="logo">
        <a href="admin-top.php">
            <img src="img/king-logo.png" width="90" height="90">
        </a>
    </div>

</div>

<div class="back-white2">
    <?php
        $pdo = new PDO($connect, USER, PASS);
        $sql = $pdo->query('select * from user');
        foreach($sql as $row){
            //$row = $sql->fetch(PDO::FETCH_ASSOC);
            echo '<div class="q_user">';
            echo '<img src="img/icon.png" height="80" width="110">';
            echo '<div class="q_profile">', $row['name'], '　さん', '<br>';
            if ($row['status_id'] == 0) {
                echo    '<div class="box1">
                        <div class="status1">STUDENT</div>
                        </div>';
            } else if ($row['status_id'] == 1) {
                echo    '<div class="box2">
                        <div class="status2">TEACHER</div>
                        </div>';
            } else {
                echo    '<div class="box3">
                        <div class="status3">GRADUATE</div>
                        </div>';
            }
            echo '</div>';
            echo '<button class="delete-user"><a class="a_color" href="#?user_id=' . $row['user_id'] . '">このユーザーを削除する></a></button>';
            echo '</div>';
            echo '<hr>';
    }
    ?>
</div>

</body>
<?php
require 'footer.php';
?>