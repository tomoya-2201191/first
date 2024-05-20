<?php
session_start();
require 'db-connect.php';
require 'header.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

?>
<div class="contents">
    <p>Q&A一覧</p>
</div>

<div class="flex">

    <div class="left">
        <div class="left-1">
            <div class="left-1-1">
                <a href="?filter=open">
                    <h3>回答受付中</h3>
                </a>
            </div>
            <div class="left-1-2">
                <a href="?filter=closed">
                    <h3>解決済み</h3>
                </a>
            </div>
            <div class="left-1-2">
                <a href="?filter=all">
                    <h3>すべて</h3>
                </a>
            </div>
        </div>

        <?php

        echo '<div class="top-question">';
        if ($filter == 'open') {
            $sql = $pdo->query('SELECT * FROM question JOIN category ON question.category_id = category.category_id WHERE flag = 0');
        } elseif ($filter == 'closed') {
            $sql = $pdo->query('SELECT * FROM question JOIN category ON question.category_id = category.category_id WHERE flag = 1');
        } else {
            $sql = $pdo->query('SELECT * FROM question JOIN category ON question.category_id = category.category_id');
        }
        echo '<ul>';
        foreach ($sql as $row) {
            $category = $row['category_name'];
            $id = $row['category_id'];
            $text = $row['q_text'];
            $answer = $row['answer_sum'];
            $date = $row['q_date'];

            // 文字数を制限して語尾に[...]を追加
            if (mb_strlen($text) > 38) {
                $text = mb_substr($text, 0, 38) . '...';
            }
            echo '<div class="top-category">', $category, '</div>';
            echo '<a href="?id=', $id, '">', $text, '</a>';

            echo '<div class="flex">';

            echo '<div class="top-answer-date">';
            echo  '💬', $answer, "　";
            echo  $date;
            echo '</div>';
            echo '</div>';

            echo "<hr>";
            echo '<br>';
        }
        echo "</ul>";
        echo "</div>";
        ?>

    </div>

    <div class="right">

        <?php

        echo '<div class="category">';
        $sql = $pdo->query('SELECT * FROM category');
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
    </div>

</div>

<?php
require 'footer.php';
?>
