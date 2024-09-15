<!-- addedtasks.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加完了</title>
    <link rel="stylesheet" href="/assets/css/styleforaddedtasks.css"> <!-- 必要に応じてCSSをリンク -->
</head>
<body>
    <div class="container">
        <h1>タスクが追加されました！</h1>
        <p>以下のタスクが正常に追加されました:</p>
        <ul> 
            <!-- echo  Input::post('taskname')だと通るけどセキュリティ上ダメっぽい-->
             <!-- XSS対策とのこと→HTMLタグを無効化することで怪しいスクリプトが実行されないようにする -->
            <li><strong>タスク名:</strong> <?php echo htmlspecialchars(Input::post('taskname'), ENT_QUOTES, 'UTF-8'); ?></li>
            <li><strong>カテゴリー:</strong> <?php echo htmlspecialchars(Input::post('category'), ENT_QUOTES, 'UTF-8'); ?></li>
            <li><strong>重要度:</strong> <?php echo htmlspecialchars(Input::post('importance'), ENT_QUOTES, 'UTF-8'); ?></li>
        </ul>
        <a href="/taskapp/create_task" class="btn">別のタスクを追加する</a>
        <a href="/taskapp/tasklist" class="btn">タスクリストを見る</a>
    </div>
</body>
</html>
