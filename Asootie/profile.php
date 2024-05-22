<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
<div class="a1"></div>

<div class="flex">

<div class="aaa">
    <?php
    $pdo= new PDO($connect,USER,PASS);
    $sql=$pdo->query('select * from user');
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="user">';
    echo '<img src="img/icon.png" height="80" width="100">';
    echo '<div class="u_name">',$row['name'],'　さん';
    echo '<div class="u_name">',$row['name'],'　さん','<br>';
    echo '</div>';
    echo '</div>';
    echo '<div class="profile">';
    echo '<div class="u_name">',$row['name'],'　さん','<br>';
    ?>
    <div class="bbb">
        
    </div>
</div>

</div>
</body>

</html>