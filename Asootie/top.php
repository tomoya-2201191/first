<?php
session_start();
require 'db-connect.php';
require 'header.php';

// フィルターの設定
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// ページ設定
$items_per_page = 7; // 1ページに表示するアイテム数
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 現在のページ番号
$offset = ($page - 1) * $items_per_page; // SQLクエリのオフセット

// データベースクエリの設定
if ($filter == 'open') {
    $sql_count = 'SELECT COUNT(*) FROM question WHERE flag = 0';
    $sql = $pdo->prepare('SELECT * FROM question JOIN category ON question.category_id = category.category_id WHERE flag = 0 LIMIT :limit OFFSET :offset');
} elseif ($filter == 'closed') {
    $sql_count = 'SELECT COUNT(*) FROM question WHERE flag = 1';
    $sql = $pdo->prepare('SELECT * FROM question JOIN category ON question.category_id = category.category_id WHERE flag = 1 LIMIT :limit OFFSET :offset');
} else {
    $sql_count = 'SELECT COUNT(*) FROM question';
    $sql = $pdo->prepare('SELECT * FROM question JOIN category ON question.category_id = category.category_id LIMIT :limit OFFSET :offset');
}

// 総アイテム数を取得
$total_items = $pdo->query($sql_count)->fetchColumn();

// 総ページ数を計算
$total_pages = ceil($total_items / $items_per_page);

// SQLクエリのプレースホルダーに値をバインド
$sql->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$sql->bindValue(':offset', $offset, PDO::PARAM_INT);
$sql->execute();

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
        echo '<ul>';
        foreach ($sql as $row) {
            $category = $row['category_name'];
            $id = $row['category_id'];
            $text = $row['q_text'];
            $answer = $row['answer_sum'];
            $date = $row['q_date'];

        /*<form method="get" action="search.php" class="search">
                <div class="searchForm">
                    <input type="text" class="searchForm-input" placeholder="Q&Aを探す">
                    <button type="submit" class="searchForm-submit"></button>
                </div>
        </form>*/
        //echo '</div>';
            // 文字数を制限して語尾に[...]を追加
            if (mb_strlen($text) > 38) {
                $text = mb_substr($text, 0, 38) . '...';
            }
            echo '<div class="top-category">', $category, '</div>';
            echo '<a href="question.php?id=', $row['q_id'], '">', $text, '</a>';

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

        // ページャーの表示
        echo '<div class="pager">';
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="?filter=', $filter, '&page=', $i, '">', $i, '</a> ';
        }
        echo '</div>';
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
</div>

<?php
require 'footer.php';
?>