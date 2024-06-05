<?php
session_start();;
require 'db-connect.php';
require 'header.php';

// データベース接続
//$conn = new mysqli($servername, $username, $password, $dbname);


// フォームが送信された場合の処理
/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $question = htmlspecialchars($_POST["question"]);
    $category = htmlspecialchars($_POST["category"]);
    $coins = intval($_POST["coins"]);

    // データベースに質問を保存
    $sql = "INSERT INTO questions (username, question, category, coins) VALUES ('$username', '$question', '$category', $coins)";
    if ($conn->query($sql) === TRUE) {
        echo "新しい質問が投稿されました";
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();*/
?>

<div class="contents">
    <p>質問投稿</p>
</div>
<div class="flex">
    <div class="left">
        <form method="post" action="">
            <div class="form-group">
                <?php
            $pdo = new PDO($connect, USER, PASS);
            $sql = $pdo->query('select * from user');
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            echo '<div class="q_user">';
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
                <button type="button" class="cancel" onclick="window.location.href='/'">キャンセル</button>
                <button type="submit" class="toukou">投稿</button>
            </div>
    </div>
    <div class="right">
        <div class="q-category">
                <h3>カテゴリを選択してください</h3>
                <select id="category" name="category" required>
                    <option value="業界">業界</option>
                    <option value="職種">職種</option>
                    <option value="自己分析">自己分析</option>
                    <option value="面接対策">面接対策</option>
                    <option value="その他">その他</option>
                </select>
        </div>
        <div class="s-coin">
            <?php
            $pdo = new PDO($connect, USER, PASS);
            $sql = $pdo->query('select * from user');
            $row = $sql->fetch(PDO::FETCH_ASSOC);
                
                echo '<h3>ベストアンサーのお礼（コイン）</h3>';
                echo '<div class="coin-group">';
                echo '<img src="img/coin.png" height="50" width="50">';
                echo '<div class="coin-text">',$row['coin'],"コイン保有中<br>";
                echo '</div></div>';
                echo '<div class="coin-group">';
                echo '<img src="img/coin.png" height="50" width="50">';
                echo '<div class="coin-text">';
                echo '<input type="number" id="coins" name="coins"value="'.$row['coin'].'"required>';
                echo '</div></div>';
                ?>
        </div>
    </div>
        </form>
</div>
</body>
</html>
