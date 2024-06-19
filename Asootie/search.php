    <?php
    require 'header.php';

    // カテゴリIDの設定
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // フィルターの設定
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

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

    // 検索キーワードの処理
    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $keyword = '%' . $_POST['keyword'] . '%';
        $sql_where .= ' AND q_text LIKE :keyword ';
        $sql_params[':keyword'] = $keyword;
    }

    $sql_count = 'SELECT COUNT(*) FROM question ' . $sql_where;
    $total_items_stmt = $pdo->prepare($sql_count);
    $total_items_stmt->execute($sql_params);
    $total_items = $total_items_stmt->fetchColumn();

    $sql_query = 'SELECT * FROM question JOIN category ON question.category_id = category.category_id ' . $sql_where . ' LIMIT :limit OFFSET :offset';
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
                <p>検索結果一覧</p>
            </div>

            <div class="flex">
                <div class="left">
                    <div class="left-1">
                        <div class="left-1-1">
                            <a href="?filter=open&id=<?php echo $category_id; ?>">
                                <h3>回答受付中</h3>
                            </a>
                        </div>
                        <div class="left-1-2">
                            <a href="?filter=closed&id=<?php echo $category_id; ?>">
                                <h3>解決済み</h3>
                            </a>
                        </div>
                        <div class="left-1-2">
                            <a href="?filter=all&id=<?php echo $category_id; ?>">
                                <h3>すべて</h3>
                            </a>
                        </div>
                    </div>

                    <?php
                    echo '<div class="top-question">';
                    echo '<ul>';
                    foreach ($sql as $row) {
                        $category = $row['category_name'];
                        $id = $row['q_id'];
                        $text = $row['q_text'];
                        $answer = $row['answer_sum'];
                        $date = $row['q_date'];

                        // 文字数を制限して語尾に[...]を追加
                        if (mb_strlen($text) > 38) {
                            $text = mb_substr($text, 0, 38) . '...';
                        }
                        echo '<div class="top-category">', htmlspecialchars($category), '</div>';
                        echo '<a class="top-text" href="question.php?id=', $id, '">', htmlspecialchars($text), '</a>';

                        echo '<div class="flex">';
                        echo '<div class="top-answer-date">';
                        echo  '💬', htmlspecialchars($answer), "　";
                        echo  htmlspecialchars($date);
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
                        echo '<a href="?filter=', $filter, '&page=', $i, '&id=', $category_id, '">', $i, '</a> ';
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
                        echo '<li><a class="category-black" href="?id=', $id, '">', htmlspecialchars($row['category_name']), "</a></li>";
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
    </div><!--wrapper -->

