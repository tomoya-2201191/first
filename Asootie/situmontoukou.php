<?php
require 'header.php';
?>

<div class="contents">
    <p>質問投稿</p>
</div>
<div class="flex">
    <div class="left">
        <form method="post" action="situmontoukou-output.php">
            <div class="form-group">
                <?php
            $pdo = new PDO($connect, USER, PASS);
            $sql = $pdo->prepare('SELECT user.*
            FROM user
            WHERE user.user_id = ?');
            $sql->execute([$_SESSION['user_id']]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            echo '<div class="q_user">';
            $icon = "dinosaur1.png";
            if ($row['best_answer'] > 20) {
                $icon = "dinosaur4.png";
            } elseif ($row['best_answer'] > 10) {
                $icon = "dinosaur3.png";
            } elseif ($row['best_answer'] > 5) {
                $icon = "dinosaur2.png";
            }
            echo '<img src="img/' . $icon . '" width="90" height="90">';
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
            echo '</div></div>'
           ?>              
            </div>
            <hr>
            <div class="form-group1">
                <textarea id="question" name="question" rows="15" class="t-area" 
                placeholder="質問を入力してください" required></textarea>
            </div>
            <hr>
            <div class="form-group">
                <button type="button" class="cancel" onclick="window.location.href='top.php'">キャンセル</button>
                <button type="submit" class="toukou">投稿</button>
            </div>
    </div>
    <div class="right">
        <div class="q-category">
                <h3>カテゴリを選択してください</h3>
                <select id="category" name="category" required>
                    <option value="1">業界</option>
                    <option value="2">自己分析</option>
                    <option value="3">インターンについて</option>
                    <option value="4">面接対策</option>
                    <option value="5">その他</option>
                </select>
        </div>
        <div class="s-coin">
            <?php
            $pdo = new PDO($connect, USER, PASS);
            $sql = $pdo->prepare('select * from user where user_id = ?');
            $sql->execute([$_SESSION['user_id']]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
                
                echo '<h3>ベストアンサーのお礼（コイン）</h3>';
                echo '<div class="coin-group">';
                echo '<img src="img/coin.png" height="50" width="50">';
                echo '<div class="coin-text">',$row['coin'],"コイン保有中<br>";
                echo '</div></div>';
                echo '<div class="coin-group">';
                echo '<img src="img/coin.png" height="50" width="50">';
                echo '<div class="coin-text">';
                echo '<input type="number" id="coins" name="coins" min="0" value="0" max="'.$row['coin'].'"required>';
                echo '</div></div>';
                ?>
        </div>
    </div>
        </form>
</div>

<?php
require 'footer.php';
?>

