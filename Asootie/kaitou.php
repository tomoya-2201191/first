<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="contents">
    <p>知恵袋>就活>回答一覧</p>
</div>

<div class="flex">

<div class="right">

<?php

echo '<div class="category">';
$sql = $pdo->query('select * from category');
echo '<br>', '　カテゴリ一覧';
echo '<hr>';
echo '<ul>';
foreach ($sql as $row) {
    $id = $row['category_id'];
    echo '<li><a href="?id=', $id, '">', $row['category_name'], "</li>";
    echo '<br>';
}
echo "</ul>";
echo '<hr>';
?>
<a href="question.php">カテゴリ一覧へ</a>

</div>

</div>


