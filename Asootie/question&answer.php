<?php
session_start();
require 'db-connect.php';
require 'header.php';
?>
<link rel="stylesheet" href="css/question&answer.css">
<div class="waku">
    <div class="questionalltext"><h2>質問一覧</h2></div>
    <p class="senn">―――――――――――――――――――――――――――――――――――――</p>
<form method="post">
    <input class="questionalldelete" type="submit" name="questionalldelete" value="一括削除" />
</form>
<?php
    if(isset($_POST['questionalldelete'])) {
        $sql = $pdo->prepare('select user.user_id,  question.q_user_id, question.q_id, answer.a_user_id, answer.q_id ,answer.a_id
        FROM user
        INNER JOIN question ON question.q_user_id = user.user_id
        INNER JOIN answer ON question.q_id = answer.q_id
        where user.user_id=?');
        $sql->execute([$_GET['id']]);
        $q_id_array = array();
        foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $q_id_array[] = $row['a_id'];
        }
        for ($i = 0; $i < count($q_id_array); $i++) {
            $sql = $pdo->prepare('delete from answer where a_id=?');
            $sql->execute(array($q_id_array[$i]));
        }
        $sql = $pdo->prepare('delete from question where q_user_id=?');
        $sql->execute([$_GET['id']]);
    } 
?>
<?php  //全ての質問内容を表示
    $sql = $pdo->prepare('select * from question where q_user_id=?');
    $sql->execute([$_GET['id']]);
    foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo '<div class="qand_date">', $row['q_date'], '</div>';
    echo '<div class="qand_text">', $row['q_text'], '</div>';
    echo '<form method="post">
        <input class="questiondelete" type="submit" name="questiondelete" value="削除" />
        </form>';
        if(isset($_POST['questiondelete'])) {
            $sql = $pdo->prepare('select user.user_id,  question.q_user_id, question.q_id, answer.a_user_id, answer.q_id ,answer.a_id
            FROM user
            INNER JOIN question ON question.q_user_id = user.user_id
            INNER JOIN answer ON question.q_id = answer.q_id
            where user.user_id=?');
            $sql->execute([$_GET['id']]);
            $q_id_array = array();
            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $q_id_array[] = $row['a_id'];
            }
            for ($i = 0; $i < count($q_id_array); $i++) {
                $sql = $pdo->prepare('delete from answer where a_id=?');
                $sql->execute(array($q_id_array[$i]));
            }
            $sql = $pdo->prepare('delete from question where q_user_id=?');
            $sql->execute([$_GET['id']]);
        } 
    echo '<hr>';
    }
?>
<div class="answeralltext"><h2>回答一覧</h2></div>
<p class="senn">―――――――――――――――――――――――――――――――――――――</p>
<form method="post">
    <input class="answeralldelete" type="submit" name="answeralldelete" value="一括削除" />
</form>
<?php
    if(isset($_POST['answeralldelete'])) {
        $sql = $pdo->prepare('delete * from answer where a_user_id=?');
        $sql->execute([$_GET['id']]);
    }
?>
<?php  //全ての回答内容を表示
    
    $sql = $pdo->prepare('select * from answer where a_user_id=?');
    $sql->execute([$_GET['id']]);
    foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo '<div class="aand_date">', $row['a_date'], '</div>';
    echo '<div class="aand_text">', $row['a_text'], '</div>';
    echo '<hr>';
    }
?>
</div>
<script src="js/top.js"></script>
</body>

</html>