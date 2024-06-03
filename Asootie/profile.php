<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<link rel="stylesheet" href="css/profile.css">
<div class="waku">
    <?php
    $pdo= new PDO($connect,USER,PASS);
    $sql=$pdo->query('select * from user');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    //ユーザー//
    echo '<div class="user">';
    echo '<img src="img/icon.png" height="80" width="100">';
    echo '<div class="u_name">',$row['name'],'　さん','<br>','</div>';
    echo '<div class="u_master">';

    if ($row['best_answer'] < 5) {
        echo    '<div class="box1">
                <div class="status1">新人</div>
                </div>';
    } elseif ($row['best_answer'] < 10) {
        echo    '<div class="box1">
                <div class="status1">STUDENT</div>
                </div>';
    } elseif ($row['best_answer'] < 20) {
        echo    '<div class="box1">
                <div class="status1">STUDENT</div>
                </div>';
    } else {
        echo    '<div class="box1">
                <div class="status1">STUDENT</div>
                </div>';
    }
    echo '</div>';
    echo '</div>';
    //プロフィール//
    echo '<div class="profile">';
    echo '<div class="t_gender">','性別','<br>','</div>';//テキスト//
    echo '<div class="p_gender">',$row['gender'],'<br>','</div>';
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
    echo '<div class="t_coin">','就活コイン','<br>','</div>';//テキスト//
    echo '<img src="img/coin.png" height="40" width="50">';
    echo '<div class="p_coin">',$row['coin'],'<br>','</div>';
    echo '</div>';
    //レコード//
    echo '<div class="record">';
    echo '<div class="t_upload">','総質問数','<br>','</div>';//テキスト//
    echo '<div class="r_upload">',$row['upload'],'<br>','</div>';
    echo '<div class="t_solution">','解決質問数','<br>','</div>';//テキスト//
    echo '<div class="r_solution">',$row['solution'],'<br>','</div>';
    echo '<div class="t_best">','ベストアンサー数','<br>','</div>';//テキスト//
    echo '<div class="r_best">',$row['best_answer'],'<br>','</div>';
    echo '<div class="t_other">','その他の回答数','<br>','</div>';//テキスト//
    echo '<div class="r_other">',$row['other'],'<br>','</div>';
    echo '</div>';
    //ボタン//
    echo '<button class="question_answer"><a class="a_color" href="#">質問＆回答一覧＞</a></button>';
    echo '<button class="user_up"><a class="a_color" href="#">個人情報更新＞</a></button>';
    ?>
</div>

<script src="js/top.js"></script>
</body>

</html>