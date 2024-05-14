<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="a1"></div>

<div class="flex">

<div class="aaa">
    <?php
    $pdo= new PDO($connect,USER,PASS);
    $sql=$pdo->query('select * from user');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="q_user">';
    echo '<img src="img/icon.png" height="80" weight="100" class="icon">';
    echo "<p>",$row['name'],"　さん","<br>";
    echo "STUDENT","</p>";
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