<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>

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
    //プロフィール//
    echo '<div class="profile">';
    echo '<div class="p_gender">',$row['gender'],'<br>','</div>';
    echo '<div class="p_status">',$row['status_id'],'<br>','</div>';
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
    echo '<div class="p_coin">',$row['coin'],'<br>','</div>';
    echo '</div>';
    //レコード//
    echo '<div class="record">';
    echo '<div class="r_upload">',$row['upload'],'<br>','</div>';
    echo '<div class="p_solution">',$row['solution'],'<br>','</div>';
    echo '<div class="p_best">',$row['best_answer'],'<br>','</div>';
    echo '<div class="p_other">',$row['other'],'<br>','</div>';
    echo '</div>';
    echo '</div>';
    ?>
</body>

</html>