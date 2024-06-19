<?php
session_start();
require 'db-connect.php';
require 'header.php';
?>
<?php
    
    $sql = $pdo->prepare('select * from question where q_user_id=?');
    $sql->execute([$_GET['id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="q&_date">', $row['q_date'], '</div>';
    echo '<div class="q&_text">', $row['q_text'], '</div>';
?>
<?php
    
    $sql = $pdo->prepare('select * from answer where a_user_id=?');
    $sql->execute([$_GET['id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="a&_date">', $row['a_date'], '</div>';
    echo '<div class="a&_text">', $row['a_text'], '</div>';
?>