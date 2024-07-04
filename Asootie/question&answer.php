<?php
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
    $sql->execute([$_GET['id']]); // Deletes all answers for the user

    $sql = $pdo->prepare('delete from question where q_user_id=?');
    $sql->execute([$_GET['id']]); // Deletes all questions for the user
  }
  ?>

  <?php // Display all questions for the user ?>
  <?php
  $sql = $pdo->prepare('select * from question where q_user_id=?');
  $sql->execute([$_GET['id']]);
  foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo '<div class="qand_date">', $row['q_date'], '</div>';
    echo '<div class="qand_text">', $row['q_text'], '</div>';

    // Form to delete this specific question
    echo '<form method="post">
        <input class="questiondelete" type="submit" name="questiondelete" value="削除" />
        <input type="hidden" name="question_id" value="' . $row['q_id'] . '" /> </form>';

    if (isset($_POST['questiondelete'])) {
      // Check if the submitted question ID matches the current row's ID
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

  <?php // Display all answers for the user ?>
  <?php
  $sql = $pdo->prepare('select * from answer where a_user_id=?');
  $sql->execute([$_GET['id']]);
  foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo '<div class="aand_date">', $row['a_date'], '</div>';
    echo '<div class="aand_text">', $row['a_text'], '</div>';

    // Form to delete this specific answer
    echo '<form method="post">
          <input class="answerdelete" type="submit" name="answerdelete" value="削除" />
          <input type="hidden" name="answer_id" value="' . $row['a_id'] . '" />
          </form>';

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

