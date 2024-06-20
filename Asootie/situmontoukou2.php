<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
    <link rel="stylesheet" type="text/css" href="situmon2.css">
</head>
<body>

<?php
$submissionComplete = true; // Simulating the submission completion
if ($submissionComplete) {
    echo '<div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p>投稿完了！</p>
                <a href="index.php" class="button">トップへ戻る ></a>
            </div>
          </div>';
}
?>

<script>
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}
</script>

</body>
</html>