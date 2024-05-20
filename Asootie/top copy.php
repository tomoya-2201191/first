<?php
session_start();;
require 'db-connect.php';
require 'header.php';

?>
<div class="contents">
    <p>Q&A一覧</p>
</div>

<div class="flex">

    <div class="left">
        <div class="left-1">
            <div class="left-1-1">
                <a href="">
                    <h3>回答受付中</h3>
                </a>
            </div>
            <div class="left-1-2">
                <a href="">
                    <h3>解決済み</h3>
                </a>
            </div>
            <div class="left-1-2">
                <a href="">
                    <h3>すべて</h3>
                </a>
            </div>
        </div>
    </div>

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
    </div>


</div>

<?php
require 'footer.php';
?>