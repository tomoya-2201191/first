<?php
require 'header.php';

?>
<link rel="stylesheet" href="css/profile.css">
<div class="waku">
    <?php
    $sql = $pdo->prepare('select * from user where user_id=?');
    $sql->execute([$_SESSION['user_id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    //ユーザー//
    echo '<div class="user">';
    $icon = "dinosaur1.png";
    if ($row['best_answer'] > 20) {
        $icon = "dinosaur4.png";
    } elseif ($row['best_answer'] > 10) {
        $icon = "dinosaur3.png";
    } elseif ($row['best_answer'] > 5) {
        $icon = "dinosaur2.png";
    }
    echo '<img src="img/' . $icon . '" width="90" height="90">';
    echo '<div class="u_name">',$row['name'],'　さん','<br>','</div>';
    echo '<div class="u_master">';

    if ($row['best_answer'] > 20) {
        echo    '<div class="p_box4">
                <div class="status4">伝説の就活生</div>
                </div>';
    } elseif ($row['best_answer'] > 10) {
        echo    '<div class="p_box2">
                <div class="status2">一人前就活生</div>
                </div>';
    } elseif ($row['best_answer'] > 5) {
        echo    
                '<div class="p_box1">
                <div class="status1">駆け出し就活生</div>
                </div>';
    } else {
        echo    '<div class="p_box3">
                <div class="status3">就活生の卵</div>
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
    $id = $_SESSION['user_id'];
    //ボタン//
    echo '<button class="question_answer" onclick="location.href=\'question&answer.php?id=' . $id . '\'">質問＆回答一覧＞</button>';
    echo '<button class="user_up" onclick="location.href=\'customer-update-input.php?id=' . $id . '\'">個人情報更新＞</button>';
    
    ?>
</div>

<button class="logout" onclick="location.href='logout.php'">ログアウト＞</button>

<script src="js/top.js"></script>
</body>

</html>