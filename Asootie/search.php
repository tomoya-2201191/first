<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="top.php"><img src="img/asootie.png" alt="ロゴ"></a>
        </div>
        <div class="search_box">
            <form method="get" action="search.php" class="search">
                <div class="searchForm">
                    <input type="text" name="search_query" class="searchForm-input" placeholder="Q&Aを探す" value="<?php echo htmlspecialchars($_GET['search_query'] ?? '', ENT_QUOTES); ?>">
                    <button type="submit" class="searchForm-submit">検索</button>
                </div>
            </form>
        </div>
        <div class="icon">
            <img src="img/icon.png" alt="アイコン">
        </div>
    </header>

    <div class="contents">
        <p>検索結果一覧</p>
    </div>

    <div class="flex">
        <div class="left">
            <div class="top-question">
                <ul>
                    <?php
                    session_start();
                    require 'db-connect.php';

                    // Get search query
                    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

                    // Pagination settings
                    $items_per_page = 7;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $items_per_page;

                    // Prepare SQL query
                    $sql = $pdo->prepare("SELECT * FROM question JOIN category ON question.category_id = category.category_id WHERE q_text LIKE :search_query LIMIT :limit OFFSET :offset");
                    $sql->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
                    $sql->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
                    $sql->bindValue(':offset', $offset, PDO::PARAM_INT);
                    $sql->execute();

                    // Fetch total items for pagination
                    $sql_count = $pdo->prepare("SELECT COUNT(*) FROM question WHERE q_text LIKE :search_query");
                    $sql_count->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
                    $sql_count->execute();
                    $total_items = $sql_count->fetchColumn();
                    $total_pages = ceil($total_items / $items_per_page);

                    // Display search results
                    foreach ($sql as $row) {
                        $category = $row['category_name'];
                        $id = $row['q_id'];
                        $text = $row['q_text'];
                        $answer = $row['answer_sum'];
                        $date = $row['q_date'];

                        // Limit text length
                        if (mb_strlen($text) > 38) {
                            $text = mb_substr($text, 0, 38) . '...';
                        }
                        echo "<div class='top-category'>{$category}</div>";
                        echo "<a class='top-text' href='question.php?id={$id}'>{$text}</a>";
                        echo "<div class='flex'>";
                        echo "<div class='top-answer-date'>💬 {$answer}　{$date}</div>";
                        echo "</div><hr><br>";
                    }
                    ?>
                </ul>
            </div>

            <!-- Pagination -->
            <div class="pager">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?search_query=" . urlencode($search_query) . "&page={$i}'>{$i}</a> ";
                }
                ?>
            </div>
        </div>

        <div class="right">
            <div class="category">
                <?php
                $sql = $pdo->query("SELECT * FROM category");
                echo '<br>カテゴリ一覧<hr><ul>';
                foreach ($sql as $row) {
                    $id = $row['category_id'];
                    echo "<li><a class='category-black' href='?id={$id}'>{$row['category_name']}</a></li><br>";
                }
                echo '</ul><hr>';
                ?>
            </div>
        </div>
    </div>
</body>

</html>
