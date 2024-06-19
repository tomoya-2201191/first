<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db-connect.php';
require 'header.php';

if (!isset($_GET['user_id'])) {
    echo 'ユーザーIDが提供されていません！';
    exit;
}

$user_id = $_GET['user_id'];

$pdo = new PDO($connect, USER, PASS);
$sql = $pdo->prepare('select * from user where user_id=?');
$sql->execute([$user_id]);
$row = $sql->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo 'ユーザーが見つかりません！';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザープロフィール</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<div class="waku">
    <div class="user">
        <img src="img/icon.png" height="80" width="100">
        <div class="u_name"><?php echo $row['name']; ?>　さん<br></div>
        <div class="u_master">
            <?php
            if ($row['best_answer'] > 20) {
                echo '<div class="box3"><div class="status3">恐竜XXX</div></div>';
            } elseif ($row['best_answer'] > 10) {
                echo '<div class="box2"><div class="status2">恐竜</div></div>';
            } elseif ($row['best_answer'] > 5) {
                echo '<div class="box1"><div class="status1">ちび恐竜</div></div>';
            } else {
                echo '<div class="box3"><div class="status3">卵</div></div>';
            }
            ?>
        </div>
    </div>
    <div class="profile">
        <div class="t_gender">性別<br></div>
        <div class="p_gender"><?php echo $row['gender']; ?><br></div>
        <hr>
        <div class="t_status">職業<br></div>
        <div class="p_status">
            <?php
            if ($row['status_id'] == 0) {
                echo '在校生';
            } elseif ($row['status_id'] == 1) {
                echo '教師';
            } else {
                echo '卒業生';
            }
            ?>
        </div>
        <hr>
        <div class="t_coin">就活コイン</div>
        <div class="t_coin_img"><img src="img/coin.png" height="50" width="50"></div>
        <div class="p_coin"><?php echo $row['coin']; ?><br></div>
    </div>
    <div class="record">
        <div class="t_upload">総質問数<br></div>
        <div class="r_upload"><?php echo $row['upload']; ?><br></div>
        <hr>
        <div class="t_solution">解決質問数<br></div>
        <div class="r_solution"><?php echo $row['solution']; ?><br></div>
        <hr>
        <div class="t_best">ベストアンサー数<br></div>
        <div class="r_best"><?php echo $row['best_answer']; ?><br></div>
        <hr>
        <div class="t_other">その他の回答数<br></div>
        <div class="r_other"><?php echo $row['other']; ?><br></div>
    </div>
    <?php
    $id = $row['user_id'];
    ?>
    <button class="question_answer"><a class="a_color" href="question&answer.php?id=<?php echo $id; ?>">質問＆回答一覧＞</a></button>
    <button class="user_up"><a class="a_color" href="customer-update-input.php?id=<?php echo $id; ?>">個人情報更新＞</a></button>
</div>
<button class="logout"><a class="a_color" href="logout.php">ログアウト＞</a></button>
<script src="js/top.js"></script>
</body>
</html>

