<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="a1"></div>

<div class="flex">

<div class="left">
    <?php
    $pdo= new PDO($connect,USER,PASS);
    $sql=$pdo->query('select * from user');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="q_user">';
    echo '<img src="img/icon.png" height="80" weight="100">';
    echo '<div class="q_profile">',$row['name'],'　さん','<br>';
    if($row['status_id'] == 0){
        echo    '<div class="box1">
                <div class="status1">STUDENT</div>
                </div></div>';
    }else if($row['status_id'] == 1){
        echo    '<div class="box2">
                <div class="status2">TEACHER</div>
                </div></div>';
    }else{
        echo    '<div class="box3">
                <div class="status3">GRADUATE</div>
                </div></div>';
    }
    
    echo '</div>';
    ?>
</div>

<div class="right">
    <?php
    echo '<div class="category">';
    $sql=$pdo->query('select * from category');
    echo '<br>','　カテゴリ一覧';
    echo '<hr>';
    echo '<ul>';
    foreach ($sql as $row) {
        $id=$row['category_id'];
        echo '<li><a href="?id=', $id, '">',$row['category_name'],"</li>";
        echo '<br>';
    }
    echo "</ul>";
    echo '<hr>';
    ?>
</div>

</div>
    <script src="js/top.js"></script> <!-- JavaScriptファイルの読み込み -->
</body>

</html>