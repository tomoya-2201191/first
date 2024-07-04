<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db-connect.php';

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザープロフィール</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/profile.css">
    <!--link rel="stylesheet" href="css/style.css"> -->
    <!-- <link rel="stylesheet" href="css/fade.css">  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButton = document.querySelector(".delete_button");

            deleteButton.addEventListener("click", function(event) {
                event.preventDefault(); // デフォルトのリンク遷移を防ぐ
                const userConfirmed = confirm("本当に削除しますか？");

                if (userConfirmed) {
                    // OKが選択された場合、リンク先に遷移
                    window.location.href = deleteButton.href;
                }
                // OK以外が選択された場合は何もせずに処理を終了
            });
        });
    </script>
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

    <div class="waku">
        <?php
        $sql = $pdo->prepare('select * from user where user_id=?');
        $sql->execute([$_GET['user_id']]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        
        // ユーザー情報表示
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
                    <div class="p_status4">伝説の就活生</div>
                    </div>';
        } elseif ($row['best_answer'] > 10) {
            echo    '<div class="p_box2">
                    <div class="p_status2">一人前就活生</div>
                    </div>';
        } elseif ($row['best_answer'] > 5) {
            echo    
                    '<div class="p_box1">
                    <div class="p_status1">駆け出し就活生</div>
                    </div>';
        } else {
            echo    '<div class="p_box3">
                    <div class="p_status3">就活生の卵</div>
                    </div>';
        }
        echo '</div>';
        echo '</div>';
        
        // プロフィール情報表示
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

        // レコード情報表示
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
        // 削除ボタン
        echo '<a class="delete_button" href="admin-delete.php?user_id=' . $id . '">このユーザーを削除する＞</a>';
        ?>
    </div>
    <script src="js/top.js"></script>
</body>

</html>
