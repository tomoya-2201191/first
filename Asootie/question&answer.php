<?php
session_start();
require 'db-connect.php';
require 'header.php';
?>
<link rel="stylesheet" href="css/question&answer.css">
<div class="waku">
  <div class="questionalltext">
    <h2>質問一覧</h2>
  </div>
  <p class="senn">―――――――――――――――――――――――――――――――――――――</p>
  <form method="post">
    <input class="questionalldelete" type="submit" name="questionalldelete" value="一括削除" />
  </form>
  <?php
  if (isset($_POST['questionalldelete'])) {
    $sql = $pdo->prepare('delete from answer where q_id in (select q_id from question where q_user_id = ?)');
    $sql->execute([$_GET['id']]); // 全ての質問に対する回答を削除

    $sql = $pdo->prepare('delete from question where q_user_id=?');
    $sql->execute([$_GET['id']]); // 全ての質問を削除
  }
  ?>

  <?php // 質問をすべて表示 ?>
  <?php
  $sql = $pdo->prepare('select * from question where q_user_id=?');
  $sql->execute([$_GET['id']]);
  foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo '<div class="qand_date">', $row['q_date'], '</div>';
    echo '<div class="qand_text">', $row['q_text'], '</div>';

    // この特定の質問を削除するためのフォーム
    echo '<form method="post" onsubmit="return confirm(\'質問「' . $row['q_text'] . '」を削除しますか？\nこの操作は取り消せません。\');">';
    echo '<input class="questiondelete" type="submit" name="questiondelete" value="削除">';
    echo '<input type="hidden" name="question_id" value="' . $row['q_id'] . '" />';
    echo '</form>';

    if (isset($_POST['questiondelete'])) {
      // 送信された質問 ID が現在の行の ID と一致するかどうかを確認
      if ($_POST['question_id'] == $row['q_id']) {
        $sql = $pdo->prepare('delete from answer where q_id=?');
        $sql->execute([$row['q_id']]);

        $sql = $pdo->prepare('delete from question where q_id=?');
        $sql->execute([$row['q_id']]);    
      }
    }
    echo '<hr>';
  }
  ?>

  <div class="answeralltext">
    <h2>回答一覧</h2>
  </div>
  <p class="senn">―――――――――――――――――――――――――――――――――――――</p>
  <form method="post">
    <input class="answeralldelete" type="submit" name="answeralldelete" value="一括削除" />
  </form>
  <?php
  if (isset($_POST['answeralldelete'])) {
    $sql = $pdo->prepare('delete from answer where a_user_id=?');
    $sql->execute([$_GET['id']]);
  }
  ?>

  <?php // 全ての回答を表示 ?>
  <?php
  $sql = $pdo->prepare('select * from answer where a_user_id=?');
  $sql->execute([$_GET['id']]);
  foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo '<div class="aand_date">', $row['a_date'], '</div>';
    echo '<div class="aand_text">', $row['a_text'], '</div>';

    // この特定の回答を削除するためのフォーム
    echo '<form method="post" onsubmit="return confirm(\'回答「' . $row['a_text'] . '」を削除しますか？\nこの操作は取り消せません。\');">';
    echo '<input class="answerdelete" type="submit" name="answerdelete" value="削除">';
    echo '<input type="hidden" name="answer_id" value="' . $row['a_id'] . '" />';
    echo '</form>';

    if (isset($_POST['answerdelete'])) {
      $sql = $pdo->prepare('delete from answer where a_id=?');
      $sql->execute([$_POST['answer_id']]);
    }
    echo '<hr>';
  }

  ?>
</div>
<?php
  if (isset($_POST['questiondelete']) || isset($_POST['answerdelete'])) {
    ?>
    <!-- 画面更新処理-->
    <script language="javascript" type="text/javascript">
        if (window.name != "any") {
          location.reload();
          window.name = "any";
        } else {
          window.name = "";
        }
    </script>
    <?php
}
require 'footer.php';
?>
<script src="js/top.js"></script>
</body>

</html>

