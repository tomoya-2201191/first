<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<link rel="stylesheet" href="css/profile.css">
<div class="waku">
    <?php
    $pdo= new PDO($connect,USER,PASS);
    $sql = $pdo->prepare('select * from user where user_id=?');
    $sql->execute([$_GET['user_id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    //ユーザー//
    echo '<div class="user">';
    echo '<img src="img/icon.png" height="80" width="100">';
    echo '<div class="u_name">',$row['name'],'　さん','<br>','</div>';
    echo '<div class="u_master">';

    if ($row['best_answer'] < 5) {
        echo    '<div class="box1">
                <div class="status1">就活素人</div>
                </div>';
    } elseif ($row['best_answer'] < 10) {
        echo    '<div class="box2">
                <div class="status2">就活中級者</div>
                </div>';
    } elseif ($row['best_answer'] < 20) {
        echo    '<div class="box3">
                <div class="status3">就活マスター</div>
                </div>';
    } else {
        echo    '<div class="box3">
                <div class="status3">STUDENT</div>
                </div>';
    }
    echo '</div>';
    echo '</div>';
    //プロフィール//
    echo '<div class="profile">';
    echo '<div class="t_gender">','性別','<br>','</div>';//テキスト//
    echo '<div class="p_gender">',$row['gender'],'<br>','</div>';
    echo '<hr>';
    echo '<div class="t_status">','職業','<br>','</div>';//テキスト//
    echo '<div class="p_status">';
    if ($row['status_id'] == 0) {
        echo    '在校生';
    } else if ($row['status_id'] == 1) {
        echo    '教師';
    } else {
        echo    '卒業生';
    }
    echo '</div>';
    echo '<hr>';
    echo '<div class="t_coin">','就活コイン','</div>';//テキスト//
    echo '<div class="t_coin_img">','<img src="img/coin.png" height="50" width="50">','</div>';
    echo '<div class="p_coin">',$row['coin'],'<br>','</div>';
    echo '</div>';
    //レコード//
    echo '<div class="record">';
    echo '<div class="t_upload">','総質問数','<br>','</div>';//テキスト//
    echo '<div class="r_upload">',$row['upload'],'<br>','</div>';
    echo '<hr>';
    echo '<div class="t_solution">','解決質問数','<br>','</div>';//テキスト//
    echo '<div class="r_solution">',$row['solution'],'<br>','</div>';
    echo '<hr>';
    echo '<div class="t_best">','ベストアンサー数','<br>','</div>';//テキスト//
    echo '<div class="r_best">',$row['best_answer'],'<br>','</div>';
    echo '<hr>';
    echo '<div class="t_other">','その他の回答数','<br>','</div>';//テキスト//
    echo '<div class="r_other">',$row['other'],'<br>','</div>';
    echo '</div>';
    $id = $_GET['user_id'];
    //ボタン//
    echo '<button class="question_answer"><a class="a_color" href="question&answer.php?q&a_id=' . $id . '">質問＆回答一覧＞</a></button>';
    echo '<button class="user_up"><a class="a_color" href="customer-update-input.php?id=' . $id . '">個人情報更新＞</a></button>';
    ?>
</div>
<?php
echo '<button class="logout"><a class="a_color" href="logout.php">ログアウト＞</a></button>';
?>
<script src="js/top.js"></script>
</body>

</html>