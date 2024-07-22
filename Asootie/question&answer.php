<?php
ob_start(); // バッファリング開始
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
    
    // 全ての質問に対する回答を削除
    $sql = $pdo->prepare('DELETE FROM answer WHERE q_id IN (SELECT q_id FROM question WHERE q_user_id = ?)');
    $sql->execute([$_GET['id']]);

    // 全ての質問を削除
    $sql = $pdo->prepare('DELETE FROM question WHERE q_user_id = ?');
    $sql->execute([$_GET['id']]);
    
    // プロフィールの投稿質問数・解決済み質問数の値を０に
    $sql = $pdo->prepare('UPDATE user SET upload = 0, solution = 0 WHERE user_id = ?');
    $sql->execute([$_GET['id']]);
    
    // ページをリロード
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}


if (isset($_POST['questiondelete'])) {
  $question_id = $_POST['question_id'];
  $user_id = $_POST['user_id']; // $_POST から user_id を取得

  // 質問のflagを取得するためにSELECTクエリを実行
  $sql = $pdo->prepare('SELECT flag FROM question WHERE q_id = ?');
  $sql->execute([$question_id]);
  $row = $sql->fetch();

  if ($row) {
      if ($row['flag'] == 1) {
          // 質問とその回答を削除
          $sql = $pdo->prepare('DELETE FROM answer WHERE q_id = ?');
          $sql->execute([$question_id]);

          $sql = $pdo->prepare('DELETE FROM question WHERE q_id = ?');
          $sql->execute([$question_id]);

          // userテーブルのuploadとsolutionの値を一つ減らす
          $sql = $pdo->prepare('UPDATE user SET upload = upload - 1, solution = solution - 1 WHERE user_id = ?');
          $sql->execute([$user_id]); // user_id を POST から取得

      } else {
          // 質問とその回答を削除
          $sql = $pdo->prepare('DELETE FROM answer WHERE q_id = ?');
          $sql->execute([$question_id]);

          $sql = $pdo->prepare('DELETE FROM question WHERE q_id = ?');
          $sql->execute([$question_id]);

          // userテーブルのuploadの値を一つ減らす
          $sql = $pdo->prepare('UPDATE user SET upload = upload - 1 WHERE user_id = ?');
          $sql->execute([$user_id]); // user_id を POST から取得
      }

      // ページをリロード
      header("Location: " . $_SERVER['REQUEST_URI']);
      exit();
  } else {
      // 該当する質問が見つからない場合の処理
      echo "指定された質問が見つかりません。";
  }
}



  if (isset($_POST['answerdelete'])) {
    $answer_id = $_POST['answer_id'];

    // ba_flag と q_id を取得
    $sql = $pdo->prepare('select ba_flag, q_id from answer where a_id=?');
    $sql->execute([$answer_id]);
    $answer = $sql->fetch(PDO::FETCH_ASSOC);

    // 回答を削除
    $sql = $pdo->prepare('delete from answer where a_id=?');
    $sql->execute([$answer_id]);

    // ベストアンサー数やその他の回答数を更新
    if ($answer && $answer['ba_flag'] == 1) {
      $sql = $pdo->prepare('update user set best_answer = best_answer - 1 where user_id = ?');
      $sql->execute([$_GET['id']]); // ベストアンサー数を一つ減らす

      $sql = $pdo->prepare('update question set flag = 0 where q_id = ?');
      $sql->execute([$answer['q_id']]); // 解決フラッグを更新

      // 回答数を1つ減らす
      $sql = $pdo->prepare('update question set answer_sum = answer_sum - 1 where q_id = ?');
      $sql->execute([$answer['q_id']]);
    } else {
      $sql = $pdo->prepare('update user set other = other - 1 where user_id = ?');
      $sql->execute([$_GET['id']]); // その他の回答数を一つ減らす

      // 回答数を1つ減らす
      $sql = $pdo->prepare('update question set answer_sum = answer_sum - 1 where q_id = ?');
      $sql->execute([$answer['q_id']]);
    }
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit();
  }
  ?>

  <?php // 質問をすべて表示 ?>
  <?php
  $sql = $pdo->prepare('select * from question where q_user_id=?');
  $sql->execute([$_GET['id']]);
  $questions = $sql->fetchAll(PDO::FETCH_ASSOC);
  foreach ($questions as $row) {
    echo '<div class="qand_date">', htmlspecialchars($row['q_date']), '</div>';
    echo '<div class="qand_text">', htmlspecialchars($row['q_text']), '</div>';

    // この特定の質問を削除するためのフォーム
    echo '<form method="post" onsubmit="return confirm(\'質問「' . htmlspecialchars($row['q_text']) . '」を削除しますか？\nこの操作は取り消せません。\');">';
    echo '<input class="questiondelete" type="submit" name="questiondelete" value="削除">';
    echo '<input type="hidden" name="question_id" value="' . htmlspecialchars($row['q_id']) . '" />';
    echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($_SESSION['user_id']) . '" />';
    echo '</form>';
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
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit();
  }
  ?>

  <?php // 全ての回答を表示 ?>
  <?php
  $sql = $pdo->prepare('select * from answer where a_user_id=?');
  $sql->execute([$_GET['id']]);
  $answers = $sql->fetchAll(PDO::FETCH_ASSOC);
  foreach ($answers as $row) {
    echo '<div class="aand_date">', htmlspecialchars($row['a_date']), '</div>';
    echo '<div class="aand_text">', htmlspecialchars($row['a_text']), '</div>';

    // この特定の回答を削除するためのフォーム
    echo '<form method="post" onsubmit="return confirm(\'回答「' . htmlspecialchars($row['a_text']) . '」を削除しますか？\nこの操作は取り消せません。\');">';
    echo '<input class="answerdelete" type="submit" name="answerdelete" value="削除">';
    echo '<input type="hidden" name="answer_id" value="' . htmlspecialchars($row['a_id']) . '" />';
    echo '</form>';
    echo '<hr>';
  }
  ?>
</div>
<?php
require 'footer.php';
?>
