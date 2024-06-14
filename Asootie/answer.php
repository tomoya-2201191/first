<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="contents">
    <p>質問回答</p>
</div>

<div class="top">
    <?php
    $pdo = new PDO($connect, USER, PASS);
    $sql = $pdo->prepare('SELECT question.*, user.*
    FROM question
    INNER JOIN user ON question.q_user_id = user.user_id 
    WHERE question.q_id = ?');
    $_SESSION['q_id'] = $_GET['q_id'];
    $sql->execute([$_SESSION['q_id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    echo '<div class="q_user1">';
    echo '<img src="img/icon.png" height="80" width="100">';
    echo '<div class="q_profile">', $row['name'], '　さん', '<br>';
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
    echo '</div>'; // q_profile の終了タグを追加
    echo '<div class="date">', $row['q_date'], '</div>';
    echo '<div class="a_sum">', $row['answer_sum'], '　回答', '</div>';
    echo '</div>'; // q_user の終了タグを修正
    echo '<div class="q_text1">', $row['q_text'], '</div>';
    ?>
</div>

<div class="bottom">
    <form method="post" action="answer-output.php">
        <?php
        $pdo = new PDO($connect, USER, PASS);
        $sql = $pdo->prepare('SELECT user.*
        FROM user
        WHERE user.user_id = ?');
        $sql->execute([$_SESSION['user_id']]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        echo '<div class="q_user1">';
        echo '<img src="img/icon.png" height="80" width="100">';
        echo '<div class="q_profile">', $row['name'], '　さんとして回答中', '<br>';
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
        echo '</div></div>'; // q_profile の終了タグを追加
        ?>
        <hr>
        <div class="form-group1">
            <textarea id="answer" name="answer" rows="15" class="t-area" 
            placeholder="回答を入力してください" required></textarea>
        </div>
        <hr>
        <button type="submit" class="kaitou">回答する</button>
    </form>
</div>

<?php
require 'footer.php';
?>

