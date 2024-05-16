<?php
// データベース接続設定
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// 1ページに表示するアイテム数
$items_per_page = 5;

// 現在のページ番号を取得（デフォルトは1ページ目）
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// 表示するアイテムの開始位置を計算
$start = ($page - 1) * $items_per_page;

// データベースからアイテムを取得
$sql = "SELECT * FROM items LIMIT $start, $items_per_page";
$result = $conn->query($sql);

// 総アイテム数を取得
$total_items_sql = "SELECT COUNT(*) FROM items";
$total_items_result = $conn->query($total_items_sql);
$total_items_row = $total_items_result->fetch_row();
$total_items = $total_items_row[0];

// 総ページ数を計算
$total_pages = ceil($total_items / $items_per_page);

// データを表示
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . $row["item_name"] . "</p>";
    }
} else {
    echo "データがありません";
}
$conn->close();
?>

<!-- ページネーションリンク -->
<div class="pagination">
    <?php if ($page > 1) : ?>
        <a href="?page=1">1</a>
        <a href="?page=<?php echo $page - 1; ?>">前へ</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <?php if ($i == $page) : ?>
            <strong><?php echo $i; ?></strong>
        <?php else : ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $total_pages) : ?>
        <a href="?page=<?php echo $page + 1; ?>">次へ</a>
        <a href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
    <?php endif; ?>
</div>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ページネーション例</title>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a,
        .pagination strong {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #007bff;
        }

        .pagination strong {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>

    <div class="contents">
        <!-- ここにPHPスクリプトの出力が表示されます -->
        <?php include 'pagination_script.php'; ?>
    </div>

</body>

</html>