<?php

require 'header.php';

// カテゴリIDの設定
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// フィルターの設定
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'open';  // デフォルトは 'open'

// ソートの設定
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'new';  // デフォルトは 'new'

// カテゴリ名の取得
$category_name = 'Q&A一覧';
if ($category_id > 0) {
    $stmt = $pdo->prepare('SELECT category_name FROM category WHERE category_id = :category_id');
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch();
    if ($category) {
        $category_name = $category['category_name'];
    }
}

// ページ設定
$items_per_page = 7; // 1ページに表示するアイテム数
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 現在のページ番号
$offset = ($page - 1) * $items_per_page; // SQLクエリのオフセット

// データベースクエリの設定
$sql_where = ' WHERE 1=1 ';
$sql_params = [];

if ($category_id > 0) {
    $sql_where .= ' AND question.category_id = :category_id ';
    $sql_params[':category_id'] = $category_id;
}

if ($filter == 'open') {
    $sql_where .= ' AND flag = 0 ';
} elseif ($filter == 'closed') {
    $sql_where .= ' AND flag = 1 ';
}

// ソート条件の設定
$sql_order = ' ORDER BY q_date DESC ';
if ($sort == 'old') {
    $sql_order = ' ORDER BY q_date ASC ';
} elseif ($sort == 'feel') {
    $sql_order = ' ORDER BY feel DESC ';
}

$sql_count = 'SELECT COUNT(*) FROM question ' . $sql_where;
$total_items_stmt = $pdo->prepare($sql_count);
$total_items_stmt->execute($sql_params);
$total_items = $total_items_stmt->fetchColumn();

$sql_query = 'SELECT * FROM question JOIN category ON question.category_id = category.category_id ' . $sql_where . $sql_order . ' LIMIT :limit OFFSET :offset';
$sql = $pdo->prepare($sql_query);

// 総ページ数を計算
$total_pages = ceil($total_items / $items_per_page);

// SQLクエリのプレースホルダーに値をバインド
$sql->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$sql->bindValue(':offset', $offset, PDO::PARAM_INT);
foreach ($sql_params as $key => $value) {
    $sql->bindValue($key, $value);
}
$sql->execute();

?>

<div class="contents">
    <p><?php echo htmlspecialchars($category_name); ?></p>
</div>

<div class="flex">
    <div class="left">
        <div class="left-1">
            <div class="left-1-1">
                <a href="?filter=open&id=<?php echo $category_id; ?>&sort=<?php echo $sort; ?>" class="<?php echo $filter == 'open' ? 'selected' : ''; ?>">
                    <h3>回答受付中</h3>
                </a>
            </div>
            <div class="left-1-2">
                <a href="?filter=closed&id=<?php echo $category_id; ?>&sort=<?php echo $sort; ?>" class="<?php echo $filter == 'closed' ? 'selected' : ''; ?>">
                    <h3>解決済み</h3>
                </a>
            </div>
            <div class="left-1-3">
                <a href="?filter=all&id=<?php echo $category_id; ?>&sort=<?php echo $sort; ?>" class="<?php echo $filter == 'all' ? 'selected' : ''; ?>">
                    <h3>すべて</h3>
                </a>
            </div>
        </div>

        <div class="top-question">
            <form method="GET" action="">
                <input type="hidden" name="id" value="<?php echo $category_id; ?>">
                <input type="hidden" name="filter" value="<?php echo $filter; ?>">

                <div class="top-pulldown">
                    <select name="sort" onchange="this.form.submit()">
                        <option value="new" <?php echo !isset($sort) || $sort == 'new' ? 'selected' : ''; ?>>日付が新しい順</option>
                        <option value="old" <?php echo isset($sort) && $sort == 'old' ? 'selected' : ''; ?>>日付が古い順</option>
                        <option value="feel" <?php echo isset($sort) && $sort == 'feel' ? 'selected' : ''; ?>>ランキング順</option>
                    </select>
                </div>
            </form>
            <ul>
                <?php
                foreach ($sql as $row) {
                    $category = $row['category_name'];
                    $id = $row['q_id'];
                    $text = $row['q_text'];
                    $answer = $row['answer_sum'];
                    $date = $row['q_date'];
                    $flag = $row['flag']; // 0: open, 1: closed

                    // 文字数を制限して語尾に[...]を追加
                    if (mb_strlen($text) > 38) {
                        $text = mb_substr($text, 0, 38) . '...';
                    }

                    // ステータスクラスの設定
                    $status_class = $flag == 0 ? 'status-open' : 'status-closed';

                    echo '<div class="top-category">', htmlspecialchars($category), '</div>';
                    echo '<a class="top-text" href="question.php?id=', $id, '">', htmlspecialchars($text), '</a>';

                    echo '<div class="flex">';
                    echo '<div class="top-answer-date ', $status_class, '">';
                    echo  '💬', htmlspecialchars($answer), "　";
                    echo  htmlspecialchars($date);
                    if ($status_class == 'status-open') {
                        echo '　回答受付中！';
                    } else {
                        echo '　解決済み！';
                    }
                    echo '</div>';
                    echo '</div>';

                    echo "<hr>";
                    echo '<br>';
                }
                ?>
            </ul>
        </div>

        <!-- ページャーの表示 -->
        <div class="pager">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $class = ($i == $page) ? 'current-page' : '';  // Add class if this is the current page
                echo '<a class="', $class, '" href="?filter=', $filter, '&sort=', $sort, '&page=', $i, '&id=', $category_id, '">', $i, '</a> ';
            }
            ?>
        </div>
    </div>


    <div class="right-ranking">
        <div class="right">
            <?php
            $sql = $pdo->query('SELECT * FROM category');
            echo '<div class="category">';
            echo '<br>', '　カテゴリ一覧';
            echo '</div>';
            echo '<hr>';

            echo '<ul class="category_box">';
            foreach ($sql as $row) {
                $id = $row['category_id'];
                echo '<li><a class="category-black" href="?id=', $id, '">', htmlspecialchars($row['category_name']), "</a></li>";
                echo '<br>';
            }
            echo "</ul>";

            echo '<hr>';
            ?>
        </div>

        <div class="ranking">
            <p class="ranking-p">共感RANKING</p>
            <ol class="ranking-ol">
                <hr>
                <?php
                // ランキング用のクエリを作成する
                $ranking_query = 'SELECT * FROM question JOIN category ON question.category_id = category.category_id ORDER BY feel DESC LIMIT 5'; // 例: 上位5件のランキング
                $ranking_stmt = $pdo->query($ranking_query);
                $rank = 1;
                foreach ($ranking_stmt as $row) {
                    echo '<li class="ranking-li">';
                    echo '<span class="rank-number">', $rank, '.</span>';
                    echo '<span class="rank-question"><a class="ranking-a" href="question.php?id=', $row['q_id'], '">', htmlspecialchars($row['q_text']), '</a></span>';
                    echo '<hr class="ranking-hr">';
                    echo '</li>';
                    $rank++;
                }
                ?>
            </ol>
        </div>
    </div>


</div>

<?php
require 'footer.php';
?>